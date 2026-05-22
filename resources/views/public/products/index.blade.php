<x-layouts.public
    title="Katalog Produk Melon | Tani Monitoring"
    meta-description="Katalog produk melon dan hasil pertanian dari kelompok tani dengan informasi harga, stok, dan kualitas produk."
>
    <section class="bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl px-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                    Katalog Produk
                </p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">
                    Produk Melon dan Hasil Pertanian
                </h1>
                <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
                    Temukan produk pertanian kelompok tani dengan informasi stok, harga, tanggal panen, dan deskripsi produk yang lebih transparan.
                </p>
            </div>

            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <form method="GET" action="{{ route('public.products.index') }}" class="grid gap-4 lg:grid-cols-4">
                    <div class="lg:col-span-2">
                        <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                            Cari Produk
                        </label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ $search }}"
                            placeholder="Cari melon premium, golden melon, paket panen..."
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        >
                    </div>

                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori
                        </label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        >
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort" class="mb-2 block text-sm font-semibold text-slate-700">
                            Urutkan
                        </label>
                        <select
                            id="sort"
                            name="sort"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        >
                            <option value="newest" @selected($sort === 'newest' || $sort === '')>Terbaru</option>
                            <option value="price_low" @selected($sort === 'price_low')>Harga Terendah</option>
                            <option value="price_high" @selected($sort === 'price_high')>Harga Tertinggi</option>
                        </select>
                    </div>

                    <div class="flex gap-3 lg:col-span-4">
                        <button type="submit" class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                            Terapkan Filter
                        </button>

                        <a href="{{ route('public.products.index') }}" class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <a href="{{ route('public.products.show', $product) }}" class="block">
                            <div class="h-52 bg-slate-100">
                                @if ($product->main_image_url)
                                    <img
                                        src="{{ $product->main_image_url }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-slate-400">
                                        Belum ada gambar
                                    </div>
                                @endif
                            </div>

                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-green-700">
                                    {{ $product->category?->name ?? 'Produk Pertanian' }}
                                </p>

                                <h2 class="mt-2 line-clamp-2 text-lg font-bold text-slate-950">
                                    {{ $product->name }}
                                </h2>

                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">
                                    {{ $product->short_description ?? 'Produk pertanian pilihan dari kelompok tani.' }}
                                </p>

                                <div class="mt-4 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-lg font-bold text-slate-950">
                                            Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            per {{ $product->unit }}
                                        </p>
                                    </div>

                                    <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Stok {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm sm:col-span-2 lg:col-span-3 xl:col-span-4">
                        Produk belum tersedia untuk filter yang dipilih.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</x-layouts.public>