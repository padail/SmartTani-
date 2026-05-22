<x-layouts.dashboard title="Manajemen Produk">
    <x-slot name="header">
        Manajemen Produk
    </x-slot>

    <section class="space-y-6">
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                    Product Management
                </p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950">
                    Produk Pertanian Kelompok Tani
                </h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                    Kelola katalog produk, harga, stok, foto, status publikasi, dan informasi SEO untuk mendukung pemasaran digital.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800"
            >
                + Tambah Produk
            </a>
        </div>

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

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.index') }}" class="grid gap-4 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                        Cari Produk
                    </label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Cari nama produk, SKU, atau deskripsi singkat"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                    >
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Kategori
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
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
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                        Status
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                    >
                        <option value="">Semua status</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                        <option value="active" @selected($status === 'active')>Active</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                        <option value="out_of_stock" @selected($status === 'out_of_stock')>Out of Stock</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row lg:col-span-4">
                    <button
                        type="submit"
                        class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                    >
                        Filter
                    </button>

                    <a
                        href="{{ route($routePrefix . '.index') }}"
                        class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Produk</th>
                            <th class="px-5 py-4">Kategori</th>
                            <th class="px-5 py-4">Harga</th>
                            <th class="px-5 py-4">Stok</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Owner</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($products as $product)
                            @php
                                $statusClass = match ($product->status) {
                                    'active' => 'bg-emerald-100 text-emerald-700',
                                    'draft' => 'bg-slate-100 text-slate-600',
                                    'inactive' => 'bg-amber-100 text-amber-700',
                                    'out_of_stock' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                            @if ($product->main_image_url)
                                                <img
                                                    src="{{ $product->main_image_url }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-400">
                                                    No Img
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-950">
                                                {{ $product->name }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                SKU: {{ $product->sku ?? '-' }}
                                            </p>
                                            @if ($product->is_featured)
                                                <span class="mt-2 inline-flex rounded-lg bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $product->category?->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                    <span class="text-xs font-medium text-slate-500">/{{ $product->unit }}</span>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $product->stock }} {{ $product->unit }}
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-lg px-3 py-1 text-xs font-semibold uppercase {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $product->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $product->owner?->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route($routePrefix . '.show', $product) }}"
                                            class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route($routePrefix . '.edit', $product) }}"
                                            class="rounded-lg bg-green-700 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-800"
                                        >
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada produk yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</x-layouts.dashboard>