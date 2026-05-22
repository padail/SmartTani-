<x-layouts.dashboard title="Detail Produk">
    <x-slot name="header">
        Detail Produk
    </x-slot>

    <section class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @php
            $statusClass = match ($product->status) {
                'active' => 'bg-emerald-100 text-emerald-700',
                'draft' => 'bg-slate-100 text-slate-600',
                'inactive' => 'bg-amber-100 text-amber-700',
                'out_of_stock' => 'bg-red-100 text-red-700',
                default => 'bg-slate-100 text-slate-600',
            };
        @endphp

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="h-80 bg-slate-100">
                        @if ($product->main_image_url)
                            <img
                                src="{{ $product->main_image_url }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-slate-400">
                                Belum ada gambar produk
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                                    {{ $product->category?->name ?? 'Tanpa Kategori' }}
                                </p>
                                <h2 class="mt-1 text-3xl font-bold text-slate-950">
                                    {{ $product->name }}
                                </h2>
                                <p class="mt-2 text-sm text-slate-500">
                                    SKU: {{ $product->sku ?? '-' }} • Slug: {{ $product->slug }}
                                </p>
                            </div>

                            <span class="inline-flex rounded-lg px-3 py-1 text-xs font-semibold uppercase {{ $statusClass }}">
                                {{ str_replace('_', ' ', $product->status) }}
                            </span>
                        </div>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Harga</p>
                                <p class="mt-2 text-lg font-bold text-slate-950">
                                    Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-slate-500">per {{ $product->unit }}</p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Stok</p>
                                <p class="mt-2 text-lg font-bold text-slate-950">
                                    {{ $product->stock }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $product->unit }}</p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Minimum Order</p>
                                <p class="mt-2 text-lg font-bold text-slate-950">
                                    {{ $product->minimum_order }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $product->unit }}</p>
                            </div>

                            <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Panen</p>
                                <p class="mt-2 text-lg font-bold text-slate-950">
                                    {{ $product->harvest_date?->format('d M Y') ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-slate-950">
                                Deskripsi Singkat
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                {{ $product->short_description ?? '-' }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-slate-950">
                                Deskripsi Lengkap
                            </h3>
                            <div class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-600">
                                {{ $product->description ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">
                        Informasi SEO
                    </h3>

                    <div class="mt-5 grid gap-4">
                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Meta Title</p>
                            <p class="mt-2 text-sm font-semibold text-slate-900">
                                {{ $product->meta_title ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Meta Description</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                {{ $product->meta_description ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">
                        Aksi Produk
                    </h3>

                    <div class="mt-5 space-y-3">
                        <a
                            href="{{ route($routePrefix . '.edit', $product) }}"
                            class="block rounded-lg bg-green-700 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-green-800"
                        >
                            Edit Produk
                        </a>

                        <a
                            href="{{ route($routePrefix . '.index') }}"
                            class="block rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Kembali ke Daftar
                        </a>

                        <form method="POST" action="{{ route($routePrefix . '.destroy', $product) }}">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Hapus produk ini? Tindakan ini tidak dapat dibatalkan.')"
                                class="w-full rounded-lg border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                            >
                                Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">
                        Informasi Pengelola
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Owner</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">
                                {{ $product->owner?->name ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $product->owner?->email ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Featured</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">
                                {{ $product->is_featured ? 'Ya' : 'Tidak' }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dibuat</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">
                                {{ $product->created_at?->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Terakhir Diubah</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">
                                {{ $product->updated_at?->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.dashboard>