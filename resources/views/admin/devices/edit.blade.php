<x-layouts.dashboard title="Edit Device">
    <x-slot name="header">
        Edit Device IoT
    </x-slot>

    <section class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-950">
                Edit {{ $device->device_code }}
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Perubahan kode device akan memengaruhi header <span class="font-semibold text-slate-900">X-Device-Code</span> yang digunakan oleh perangkat IoT.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.devices.update', $device) }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            @include('admin.devices._form', ['device' => $device])

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <button
                    type="submit"
                    class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                >
                    Simpan Perubahan
                </button>

                <a href="{{ route('admin.devices.show', $device) }}"
                   class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </section>
</x-layouts.dashboard>