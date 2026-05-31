<?php

namespace App\Services\Marketplace;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getActiveCart(User $user): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
    }

    public function getActiveCartWithItems(User $user): Cart
    {
        return $this->getActiveCart($user)
            ->load(['items.product.category:id,name']);
    }

    public function addProduct(User $user, Product $product, int $quantity): Cart
    {
        if ($product->status !== 'active') {
            throw ValidationException::withMessages([
                'product' => 'Produk belum tersedia untuk dibeli.',
            ]);
        }

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Stok produk tidak mencukupi.',
            ]);
        }

        return DB::transaction(function () use ($user, $product, $quantity) {
            $cart = $this->getActiveCart($user);

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            $newQuantity = $quantity + ($item?->quantity ?? 0);

            if ($product->stock < $newQuantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Jumlah di keranjang melebihi stok produk.',
                ]);
            }

            if ($item) {
                $item->update([
                    'quantity' => $newQuantity,
                    'price' => $product->price,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            return $cart->fresh(['items.product']);
        });
    }

    public function updateItem(User $user, CartItem $item, int $quantity): Cart
    {
        $cart = $this->getActiveCart($user);

        if ((int) $item->cart_id !== (int) $cart->id) {
            abort(403, 'Item keranjang tidak valid.');
        }

        $product = $item->product;

        if (! $product || $product->status !== 'active') {
            throw ValidationException::withMessages([
                'quantity' => 'Produk tidak tersedia.',
            ]);
        }

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Jumlah melebihi stok produk.',
            ]);
        }

        $item->update([
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        return $cart->fresh(['items.product']);
    }

    public function removeItem(User $user, CartItem $item): Cart
    {
        $cart = $this->getActiveCart($user);

        if ((int) $item->cart_id !== (int) $cart->id) {
            abort(403, 'Item keranjang tidak valid.');
        }

        $item->delete();

        return $cart->fresh(['items.product']);
    }

    public function ensureCartCanCheckout(Cart $cart): void
    {
        $cart->loadMissing('items.product');

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Keranjang masih kosong.',
            ]);
        }

        foreach ($cart->items as $item) {
            $product = $item->product;

            if (! $product || $product->status !== 'active') {
                throw ValidationException::withMessages([
                    'cart' => "Produk {$item->product?->name} tidak tersedia.",
                ]);
            }

            if ($item->quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'cart' => "Stok produk {$product->name} tidak mencukupi.",
                ]);
            }
        }
    }
}