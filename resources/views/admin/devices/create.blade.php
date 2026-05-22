<x-layouts.dashboard title="Tambah Device">
    <x-slot name="header">
        Tambah Device IoT
    </x-slot>

    <section class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-950">
                Data Device Baru
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Setelah device dibuat, sistem akan membuat API key otomatis. Simpan API key tersebut karena hanya ditampilkan satu kali.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.devices.store') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            @include('admin.devices._form')

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <button
                    type="submit"
                    class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                >
                    Simpan Device
                </button>

                <a href="{{ route('admin.devices.index') }}"
                   class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </section>
</x-layouts.dashboard>