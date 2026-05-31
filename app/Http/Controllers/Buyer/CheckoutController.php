<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CalculateShippingRequest;
use App\Http\Requests\Checkout\StoreCheckoutRequest;
use App\Models\Order;
use App\Services\Marketplace\CartService;
use App\Services\Marketplace\CheckoutService;
use App\Services\Marketplace\ShippingRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(CartService $cartService): View|RedirectResponse
    {
        $cart = $cartService->getActiveCartWithItems(auth()->user());

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('buyer.cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $addresses = auth()->user()
            ->buyerAddresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view('buyer.checkout.index', compact('cart', 'addresses'));
    }

    public function calculateShipping(
        CalculateShippingRequest $request,
        CartService $cartService,
        ShippingRateService $shippingRateService
    ): JsonResponse {
        $cart = $cartService->getActiveCartWithItems($request->user());
        $cartService->ensureCartCanCheckout($cart);

        $rates = $shippingRateService->calculate(
            destinationId: $request->validated('destination_id'),
            weightGram: $cart->total_weight_gram,
            courier: $request->validated('courier') ?: null,
        );

        return response()->json([
            'data' => $rates,
        ]);
    }

    public function store(
        StoreCheckoutRequest $request,
        CheckoutService $checkoutService
    ): RedirectResponse {
        $order = $checkoutService->createOrder(
            user: $request->user(),
            data: $request->validated(),
        );

        return redirect()
            ->route('buyer.orders.show', $order)
            ->with('success', 'Order berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function show(Order $order): View
    {
        abort_unless((int) $order->buyer_id === (int) auth()->id(), 403);

        $order->load(['items', 'payment']);

        return view('buyer.orders.show', [
            'order' => $order,
            'snapUrl' => config('services.midtrans.snap_url'),
            'midtransClientKey' => config('services.midtrans.client_key'),
        ]);
    }
}
