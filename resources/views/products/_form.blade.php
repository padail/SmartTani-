@php
$product = $product ?? null;
@endphp

<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Informasi Utama Produk
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Isi informasi dasar produk yang akan tampil pada katalog.
            </p>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                @if (auth()->user()->role === 'admin')
                <div class="lg:col-span-2">
                    <label for="owner_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Owner Produk
                    </label>
                    <select
                        id="owner_id"
                        name="owner_id"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                        <option value="">Gunakan akun admin saat ini</option>
                        @foreach ($owners as $owner)
                        <option value="{{ $owner->id }}" @selected((string) old('owner_id', $product?->owner_id) === (string) $owner->id)>
                            {{ $owner->name }} — {{ $owner->email }}
                        </option>
                        @endforeach
                    </select>
                    @error('owner_id')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <div class="lg:col-span-2">
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Produk
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $product?->name) }}"
                        placeholder="Contoh: Golden Melon Premium"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                    @error('name')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="mb-2 block text-sm font-semibold text-slate-700">
                        SKU
                    </label>
                    <input
                        id="sku"
                        name="sku"
                        type="text"
                        value="{{ old('sku', $product?->sku) }}"
                        placeholder="Contoh: MELON-GOLD-001"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                    @error('sku')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Kategori
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="short_description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Deskripsi Singkat
                    </label>
                    <input
                        id="short_description"
                        name="short_description"
                        type="text"
                        value="{{ old('short_description', $product?->short_description) }}"
                        placeholder="Ringkasan singkat produk untuk kartu katalog"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                    @error('short_description')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Deskripsi Lengkap
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        placeholder="Jelaskan kualitas produk, proses budidaya, keunggulan, dan informasi lain yang relevan."
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">{{ old('description', $product?->description) }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Harga, Stok, dan Panen
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Informasi ini akan dipakai untuk katalog, checkout, dan perhitungan transaksi.
            </p>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div>
                    <label for="price" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga
                    </label>
                    @php
                    $priceValue = old('price', $product?->price);
                    $formattedPrice = $priceValue !== null && $priceValue !== ''
                    ? 'Rp ' . number_format((float) $priceValue, 0, ',', '.')
                    : '';
                    @endphp

                    <input
                        id="price"
                        name="price"
                        type="text"
                        inputmode="numeric"
                        value="{{ $formattedPrice }}"
                        placeholder="Rp 20.000"
                        autocomplete="off"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                    <p class="mt-2 text-xs text-slate-500">
                        Contoh penulisan: Rp 20.000 atau Rp 150.000
                    </p>
                    @error('price')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="mb-2 block text-sm font-semibold text-slate-700">
                        Satuan
                    </label>
                    <input
                        id="unit"
                        name="unit"
                        type="text"
                        value="{{ old('unit', $product?->unit ?? 'kg') }}"
                        placeholder="kg / buah / paket"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                    @error('unit')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="mb-2 block text-sm font-semibold text-slate-700">
                        Stok
                    </label>
                    <input
                        id="stock"
                        name="stock"
                        type="number"
                        min="0"
                        step="1"
                        value="{{ old('stock', $product?->stock ?? 0) }}"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                    @error('stock')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minimum_order" class="mb-2 block text-sm font-semibold text-slate-700">
                        Minimum Order
                    </label>
                    <input
                        id="minimum_order"
                        name="minimum_order"
                        type="number"
                        min="1"
                        step="1"
                        value="{{ old('minimum_order', $product?->minimum_order ?? 1) }}"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                    @error('minimum_order')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harvest_date" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tanggal Panen
                    </label>
                    <input
                        id="harvest_date"
                        name="harvest_date"
                        type="date"
                        value="{{ old('harvest_date', $product?->harvest_date?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                    @error('harvest_date')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
                        Status Produk
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                        required>
                        <option value="draft" @selected(old('status', $product?->status ?? 'draft') === 'draft')>Draft</option>
                        <option value="active" @selected(old('status', $product?->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $product?->status) === 'inactive')>Inactive</option>
                        <option value="out_of_stock" @selected(old('status', $product?->status) === 'out_of_stock')>Out of Stock</option>
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                SEO Produk
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Meta title dan meta description membantu produk lebih siap untuk halaman katalog publik.
            </p>

            <div class="mt-6 grid gap-5">
                <div>
                    <label for="meta_title" class="mb-2 block text-sm font-semibold text-slate-700">
                        Meta Title
                    </label>
                    <input
                        id="meta_title"
                        name="meta_title"
                        type="text"
                        maxlength="160"
                        value="{{ old('meta_title', $product?->meta_title) }}"
                        placeholder="Contoh: Golden Melon Premium dari Kelompok Tani Banyu Urip"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                    @error('meta_title')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="meta_description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Meta Description
                    </label>
                    <textarea
                        id="meta_description"
                        name="meta_description"
                        rows="3"
                        maxlength="255"
                        placeholder="Deskripsi ringkas produk untuk mesin pencari."
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">{{ old('meta_description', $product?->meta_description) }}</textarea>
                    @error('meta_description')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Foto Produk
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Gunakan gambar jelas, tidak buram, dan mewakili produk.
            </p>

            <div class="mt-5 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                <img
                    id="imagePreview"
                    src="{{ $product?->main_image_url ?? '' }}"
                    alt="Preview produk"
                    class="{{ $product?->main_image_url ? '' : 'hidden' }} h-56 w-full object-cover">

                <div id="emptyPreview" class="{{ $product?->main_image_url ? 'hidden' : '' }} flex h-56 w-full items-center justify-center text-sm font-semibold text-slate-400">
                    Belum ada gambar
                </div>
            </div>

            <div class="mt-5">
                <input
                    id="main_image"
                    name="main_image"
                    type="file"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-green-700 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-green-800">
                @error('main_image')
                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Pengaturan Tampilan
            </h3>

            <label class="mt-4 flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <input
                    type="checkbox"
                    name="is_featured"
                    value="1"
                    class="mt-1 rounded border-slate-300 text-green-700 focus:ring-green-700"
                    @checked(old('is_featured', $product?->is_featured))
                >
                <span>
                    <span class="block text-sm font-semibold text-slate-900">
                        Jadikan Produk Unggulan
                    </span>
                    <span class="mt-1 block text-sm leading-5 text-slate-500">
                        Produk unggulan dapat ditampilkan di landing page atau bagian rekomendasi.
                    </span>
                </span>
            </label>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Aksi
            </h3>

            <div class="mt-5 space-y-3">
                <button
                    type="submit"
                    class="w-full rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                    {{ $submitLabel ?? 'Simpan Produk' }}
                </button>

                <a
                    href="{{ route($routePrefix . '.index') }}"
                    class="block rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </div>
    </aside>
</div>

<script>
    const imageInput = document.getElementById('main_image');
    const imagePreview = document.getElementById('imagePreview');
    const emptyPreview = document.getElementById('emptyPreview');

    imageInput?.addEventListener('change', function() {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const previewUrl = URL.createObjectURL(file);

        imagePreview.src = previewUrl;
        imagePreview.classList.remove('hidden');
        emptyPreview.classList.add('hidden');
    });
    const priceInput = document.getElementById('price');

    function onlyDigits(value) {
        return value.replace(/\D/g, '');
    }

    function formatRupiah(value) {
        const digits = onlyDigits(value);

        if (!digits) {
            return '';
        }

        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(digits));
    }

    priceInput?.addEventListener('input', function() {
        this.value = formatRupiah(this.value);
    });

    priceInput?.form?.addEventListener('submit', function() {
        if (priceInput) {
            priceInput.value = onlyDigits(priceInput.value);
        }
    });
</script>