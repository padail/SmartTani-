<?php

namespace App\Services\Marketplace;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\BuyerAddress;

class CheckoutService
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly ShippingRateService $shippingRateService,
        private readonly MidtransPaymentService $paymentService,
    ) {}

    public function createOrder(User $user, array $data): Order
    {

        $cart = $this->cartService->getActiveCartWithItems($user);
        $this->cartService->ensureCartCanCheckout($cart);
        $buyerAddress = null;

        if (! empty($data['buyer_address_id'])) {
            $buyerAddress = BuyerAddress::where('user_id', $user->id)
                ->whereKey($data['buyer_address_id'])
                ->firstOrFail();

            $data['recipient_name'] = $buyerAddress->recipient_name;
            $data['recipient_phone'] = $buyerAddress->recipient_phone;
            $data['shipping_address'] = $buyerAddress->address;
            $data['destination_id'] = $buyerAddress->destination_id;
            $data['destination_label'] = $buyerAddress->destination_label;
        }
        return DB::transaction(function () use ($buyerAddress, $user, $cart, $data) {
            $cart->load('items.product');

            $subtotal = 0;
            $totalWeight = 0;

            foreach ($cart->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->status !== 'active') {
                    throw ValidationException::withMessages([
                        'cart' => "Produk {$product->name} tidak aktif.",
                    ]);
                }

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Stok produk {$product->name} tidak mencukupi.",
                    ]);
                }

                $subtotal += (float) $product->price * $item->quantity;
                $totalWeight += (int) $product->weight_gram * $item->quantity;
            }

            $selectedRate = $this->shippingRateService->findSelectedRate(
                destinationId: $data['destination_id'],
                weightGram: $totalWeight,
                courier: $data['shipping_courier'],
                service: $data['shipping_service'],
                fallbackCost: (float) $data['shipping_cost'],
                fallbackEtd: $data['shipping_etd'] ?? null,
            );

            $shippingCost = (float) $selectedRate['cost'];
            $grandTotal = $subtotal + $shippingCost;

            $order = Order::create([
                'order_code' => $this->generateOrderCode(),
                'buyer_id' => $user->id,
                'buyer_address_id' => $buyerAddress?->id,
                'status' => 'waiting_payment',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'total_weight_gram' => $totalWeight,

                'recipient_name' => $data['recipient_name'],
                'recipient_phone' => $data['recipient_phone'],
                'shipping_address' => $data['shipping_address'],
                'destination_id' => $data['destination_id'],
                'destination_label' => $data['destination_label'] ?? null,

                'shipping_courier' => $selectedRate['courier'],
                'shipping_service' => $selectedRate['service'],
                'shipping_etd' => $selectedRate['etd'],

                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $itemSubtotal = (float) $product->price * $item->quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item->quantity,
                    'unit' => $product->unit,
                    'weight_gram' => $product->weight_gram,
                    'price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ]);

                $product->decrement('stock', $item->quantity);

                if ($product->fresh()->stock <= 0) {
                    $product->update(['status' => 'out_of_stock']);
                }
            }

            $payment = $order->payment()->create([
                'payment_gateway' => 'midtrans',
                'status' => 'pending',
                'gross_amount' => $order->grand_total,
            ]);

            $snapToken = $this->paymentService->createSnapToken($order->fresh(['buyer', 'items', 'payment']));

            $payment->update([
                'snap_token' => $snapToken,
            ]);

            $cart->items()->delete();
            $cart->update(['status' => 'checkout']);

            return $order->fresh(['items', 'payment']);
        });
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
