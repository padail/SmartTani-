<x-layouts.dashboard title="Keranjang Belanja">
    <x-slot name="header">
        Keranjang Belanja
    </x-slot>

    <section class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-bold">Keranjang belum bisa diproses.</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                Shopping Cart
            </p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950">
                Produk di Keranjang
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Periksa jumlah produk sebelum melanjutkan ke checkout.
            </p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-2">
                @forelse ($cart->items as $item)
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <div class="h-28 w-28 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                @if ($item->product?->main_image_url)
                                    <img
                                        src="{{ $item->product->main_image_url }}"
                                        alt="{{ $item->product->name }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-400">
                                        No Img
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-bold text-slate-950">
                                    {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Harga: Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                                    / {{ $item->product?->unit ?? '-' }}
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Stok tersedia: {{ $item->product?->stock ?? 0 }} {{ $item->product?->unit ?? '' }}
                                </p>

                                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <form method="POST" action="{{ route('buyer.cart.items.update', $item) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            max="{{ $item->product?->stock ?? 1 }}"
                                            value="{{ $item->quantity }}"
                                            class="w-24 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                                        >

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-800"
                                        >
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('buyer.cart.items.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="sm:text-right">
                                <p class="text-sm font-semibold text-slate-500">
                                    Subtotal
                                </p>
                                <p class="mt-1 text-xl font-bold text-slate-950">
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                        <p class="text-lg font-bold text-slate-950">
                            Keranjang masih kosong
                        </p>
                        <p class="mt-2 text-sm text-slate-600">
                            Tambahkan produk dari katalog sebelum checkout.
                        </p>
                        <a
                            href="{{ route('public.products.index') }}"
                            class="mt-5 inline-flex rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                        >
                            Lihat Katalog Produk
                        </a>
                    </div>
                @endforelse
            </div>

            <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:self-start">
                <h3 class="text-lg font-bold text-slate-950">
                    Ringkasan Keranjang
                </h3>

                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jumlah Item</span>
                        <span class="font-semibold text-slate-900">{{ $cart->items->sum('quantity') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Berat Total</span>
                        <span class="font-semibold text-slate-900">{{ number_format($cart->total_weight_gram) }} gram</span>
                    </div>

                    <div class="flex justify-between border-t border-slate-200 pt-3">
                        <span class="font-semibold text-slate-700">Subtotal</span>
                        <span class="font-bold text-slate-950">
                            Rp{{ number_format($cart->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <a
                    href="{{ route('buyer.checkout.index') }}"
                    class="mt-6 block rounded-lg bg-green-700 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-green-800 {{ $cart->items->isEmpty() ? 'pointer-events-none opacity-50' : '' }}"
                >
                    Lanjut Checkout
                </a>

                <a
                    href="{{ route('public.products.index') }}"
                    class="mt-3 block rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Tambah Produk Lain
                </a>
            </aside>
        </div>
    </section>
</x-layouts.dashboard>