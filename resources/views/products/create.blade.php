<x-layouts.dashboard title="Tambah Produk">
    <x-slot name="header">
        Tambah Produk
    </x-slot>

    <section class="space-y-6">
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-bold">Data belum bisa disimpan.</p>
                <p class="mt-1">Periksa kembali field yang masih bermasalah.</p>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route($routePrefix . '.store') }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf

            @include('products._form', [
                'submitLabel' => 'Simpan Produk',
            ])
        </form>
    </section>
</x-layouts.dashboard>