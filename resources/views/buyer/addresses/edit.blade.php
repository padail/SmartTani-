<x-layouts.dashboard title="Edit Alamat">
    <x-slot name="header">
        Edit Alamat
    </x-slot>

    <section class="space-y-6">
        <form method="POST" action="{{ route('buyer.addresses.update', $address) }}"
              class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            @include('buyer.addresses._form', ['address' => $address])

            <div class="mt-6 flex gap-3">
                <button class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">
                    Simpan Perubahan
                </button>
                <a href="{{ route('buyer.addresses.index') }}"
                   class="rounded-lg border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </section>
</x-layouts.dashboard>