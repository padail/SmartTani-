<x-layouts.public
    title="{{ $product->meta_title ?? $product->name . ' | Tani Monitoring' }}"
    meta-description="{{ $product->meta_description ?? $product->short_description ?? 'Detail produk pertanian kelompok tani.' }}">
    <section class="bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-6">
                <a href="{{ route('public.products.index') }}" class="text-sm font-semibold text-green-700 hover:text-green-800">
                    ← Kembali ke Katalog
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="h-[420px] bg-slate-100">
                        @if ($product->main_image_url)
                        <img
                            src="{{ $product->main_image_url }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover">
                        @else
                        <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-slate-400">
                            Belum ada gambar produk
                        </div>
                        @endif
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                        {{ $product->category?->name ?? 'Produk Pertanian' }}
                    </p>

                    <h1 class="mt-2 text-3xl font-bold text-slate-950">
                        {{ $product->name }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        {{ $product->short_description ?? 'Produk pertanian pilihan dari kelompok tani.' }}
                    </p>

                    <div class="mt-6 rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-sm font-semibold text-slate-500">
                            Harga Produk
                        </p>
                        <p class="mt-1 text-3xl font-bold text-slate-950">
                            Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            <span class="text-sm font-semibold text-slate-500">/{{ $product->unit }}</span>
                        </p>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Stok</p>
                            <p class="mt-2 text-lg font-bold text-slate-950">{{ $product->stock }}</p>
                            <p class="text-xs text-slate-500">{{ $product->unit }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Min. Order</p>
                            <p class="mt-2 text-lg font-bold text-slate-950">{{ $product->minimum_order }}</p>
                            <p class="text-xs text-slate-500">{{ $product->unit }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Panen</p>
                            <p class="mt-2 text-lg font-bold text-slate-950">
                                {{ $product->harvest_date?->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        @auth
                        @auth
                        @if (auth()->user()->role === 'buyer')
                        <form
                            method="POST"
                            action="{{ route('buyer.cart.items.store', $product) }}"
                            class="flex flex-col gap-3 sm:flex-row">
                            @csrf

                            <input
                                type="number"
                                name="quantity"
                                min="{{ $product->minimum_order }}"
                                max="{{ $product->stock }}"
                                value="{{ $product->minimum_order }}"
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10 sm:w-32">

                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                                Tambah ke Keranjang
                            </button>
                        </form>
                        @else
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                            Masuk Dashboard
                        </a>
                        @endif
                        @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                            Login untuk Membeli
                        </a>
                        @endauth
                        @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                            Login untuk Membeli
                        </a>
                        @endauth

                        <a
                            href="https://wa.me/?text={{ urlencode('Halo, saya ingin bertanya tentang produk ' . $product->name) }}"
                            target="_blank"
                            class="inline-flex justify-center rounded-lg border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Tanya via WhatsApp
                        </a>
                    </div>

                    <!-- <p class="mt-4 text-xs leading-5 text-slate-500">
                        Fitur keranjang dan checkout akan diaktifkan pada tahap berikutnya.
                    </p> -->
                </div>
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-950">
                    Deskripsi Produk
                </h2>

                <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600">
                    {{ $product->description ?? 'Belum ada deskripsi lengkap.' }}
                </div>
            </div>

            @if ($relatedProducts->isNotEmpty())
            <div class="mt-10">
                <h2 class="text-2xl font-bold text-slate-950">
                    Produk Terkait
                </h2>

                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <a href="{{ route('public.products.show', $related) }}" class="block">
                            <div class="h-44 bg-slate-100">
                                @if ($related->main_image_url)
                                <img
                                    src="{{ $related->main_image_url }}"
                                    alt="{{ $related->name }}"
                                    class="h-full w-full object-cover"
                                    loading="lazy">
                                @else
                                <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-400">
                                    Belum ada gambar
                                </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <p class="line-clamp-2 text-sm font-bold text-slate-950">
                                    {{ $related->name }}
                                </p>
                                <p class="mt-2 text-sm font-bold text-green-700">
                                    Rp{{ number_format((float) $related->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
</x-layouts.public>