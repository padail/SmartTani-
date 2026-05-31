<x-layouts.dashboard title="Tambah Alamat">
    <x-slot name="header">
        Tambah Alamat
    </x-slot>

    <section class="space-y-6">
        <form method="POST" action="{{ route('buyer.addresses.store') }}"
              class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            @include('buyer.addresses._form')

            <div class="mt-6 flex gap-3">
                <button class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">
                    Simpan Alamat
                </button>
                <a href="{{ route('buyer.addresses.index') }}"
                   class="rounded-lg border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </section>
</x-layouts.dashboard>