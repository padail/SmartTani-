<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\Marketplace\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $cartService): View
    {
        $cart = $cartService->getActiveCartWithItems(auth()->user());

        return view('buyer.cart.index', compact('cart'));
    }

    public function store(
        StoreCartItemRequest $request,
        Product $product,
        CartService $cartService
    ): RedirectResponse {
        $cartService->addProduct(
            user: $request->user(),
            product: $product,
            quantity: (int) $request->validated('quantity'),
        );

        return redirect()
            ->route('buyer.cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(
        UpdateCartItemRequest $request,
        CartItem $cartItem,
        CartService $cartService
    ): RedirectResponse {
        $cartService->updateItem(
            user: $request->user(),
            item: $cartItem,
            quantity: (int) $request->validated('quantity'),
        );

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function destroy(CartItem $cartItem, CartService $cartService): RedirectResponse
    {
        $cartService->removeItem(auth()->user(), $cartItem);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}