<?php

namespace App\Services\Marketplace;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransPaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Order $order): string
    {
        $order->loadMissing(['buyer', 'items', 'payment']);

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) round((float) $order->grand_total),
            ],
            'customer_details' => [
                'first_name' => $order->buyer?->name,
                'email' => $order->buyer?->email,
                'phone' => $order->recipient_phone,
                'shipping_address' => [
                    'first_name' => $order->recipient_name,
                    'phone' => $order->recipient_phone,
                    'address' => $order->shipping_address,
                ],
            ],
            'item_details' => $this->buildItemDetails($order),
        ];

        return Snap::getSnapToken($params);
    }

    public function handleNotification(array $payload): void
    {
        $orderCode = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        if (! $orderCode || ! $statusCode || ! $grossAmount || ! $signatureKey) {
            abort(400, 'Payload Midtrans tidak lengkap.');
        }

        $expectedSignature = hash(
            'sha512',
            $orderCode.$statusCode.$grossAmount.config('services.midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $signatureKey)) {
            abort(403, 'Signature Midtrans tidak valid.');
        }

        DB::transaction(function () use ($payload, $orderCode) {
            $order = Order::where('order_code', $orderCode)
                ->with(['items', 'payment'])
                ->lockForUpdate()
                ->firstOrFail();

            $transactionStatus = $payload['transaction_status'] ?? 'pending';
            $paymentType = $payload['payment_type'] ?? null;
            $transactionId = $payload['transaction_id'] ?? null;

            $payment = $order->payment ?: new Payment([
                'order_id' => $order->id,
                'payment_gateway' => 'midtrans',
                'gross_amount' => $order->grand_total,
            ]);

            $payment->fill([
                'transaction_id' => $transactionId,
                'payment_type' => $paymentType,
                'status' => $this->normalizePaymentStatus($transactionStatus),
                'raw_response' => $payload,
            ])->save();

            if (in_array($transactionStatus, ['settlement', 'capture'], true)) {
                $order->forceFill([
                    'status' => 'paid',
                    'paid_at' => now(),
                ])->save();

                return;
            }

            if ($transactionStatus === 'pending') {
                $order->forceFill([
                    'status' => 'waiting_payment',
                ])->save();

                return;
            }

            if (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)) {
                $order->forceFill([
                    'status' => $transactionStatus === 'expire' ? 'expired' : 'cancelled',
                ])->save();

                $this->restoreStockOnce($order);
            }
        });
    }

    private function buildItemDetails(Order $order): array
    {
        $items = $order->items->map(function ($item) {
            return [
                'id' => (string) ($item->product_id ?? $item->id),
                'price' => (int) round((float) $item->price),
                'quantity' => (int) $item->quantity,
                'name' => mb_substr($item->product_name, 0, 50),
            ];
        })->values()->all();

        if ((float) $order->shipping_cost > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => (int) round((float) $order->shipping_cost),
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        return $items;
    }

    private function normalizePaymentStatus(string $status): string
    {
        return match ($status) {
            'settlement' => 'settlement',
            'capture' => 'capture',
            'deny' => 'deny',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'failure' => 'failure',
            default => 'pending',
        };
    }

    private function restoreStockOnce(Order $order): void
    {
        if ($order->stock_restored_at) {
            return;
        }

        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            Product::whereKey($item->product_id)->increment('stock', $item->quantity);
        }

        $order->forceFill([
            'stock_restored_at' => now(),
        ])->save();

        Log::info('Order stock restored', [
            'order_code' => $order->order_code,
        ]);
    }
}