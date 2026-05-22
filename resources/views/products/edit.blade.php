<x-layouts.dashboard title="Edit Produk">
    <x-slot name="header">
        Edit Produk
    </x-slot>

    <section class="space-y-6">
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-bold">Data belum bisa diperbarui.</p>
                <p class="mt-1">Periksa kembali field yang masih bermasalah.</p>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                Edit Product
            </p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950">
                {{ $product->name }}
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Slug saat ini: <span class="font-semibold text-slate-900">{{ $product->slug }}</span>
            </p>
        </div>

        <form
            method="POST"
            action="{{ route($routePrefix . '.update', $product) }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            @include('products._form', [
                'product' => $product,
                'submitLabel' => 'Simpan Perubahan',
            ])
        </form>
    </section>
</x-layouts.dashboard>