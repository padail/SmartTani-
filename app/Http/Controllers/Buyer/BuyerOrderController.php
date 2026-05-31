<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Marketplace\MidtransPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BuyerOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['payment'])
            ->where('buyer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_unless((int) $order->buyer_id === (int) auth()->id(), 403);

        $order->load(['items', 'payment', 'buyerAddress']);

        return view('buyer.orders.show', [
            'order' => $order,
            'snapUrl' => config('services.midtrans.snap_url'),
            'midtransClientKey' => config('services.midtrans.client_key'),
        ]);
    }

    public function refreshPayment(Order $order, MidtransPaymentService $paymentService): RedirectResponse
    {
        abort_unless((int) $order->buyer_id === (int) auth()->id(), 403);

        if (! in_array($order->status, ['pending', 'waiting_payment'], true)) {
            return back()->with('error', 'Pembayaran tidak dapat dibuat ulang untuk status pesanan saat ini.');
        }

        $order->load(['buyer', 'items', 'payment']);

        $payment = $order->payment;

        if (! $payment) {
            $payment = $order->payment()->create([
                'payment_gateway' => 'midtrans',
                'status' => 'pending',
                'gross_amount' => $order->grand_total,
            ]);
        }

        $snapToken = $paymentService->createSnapToken($order);

        $payment->update([
            'snap_token' => $snapToken,
            'status' => 'pending',
            'gross_amount' => $order->grand_total,
        ]);

        return back()->with('success', 'Token pembayaran berhasil dibuat ulang. Silakan klik Bayar Sekarang.');
    }
}