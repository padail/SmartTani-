<x-layouts.dashboard title="Detail Device">
    <x-slot name="header">
        Detail Device IoT
    </x-slot>

    <section class="space-y-6">
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

        @if (session('generated_api_key'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <p class="text-sm font-bold text-amber-800">
                    API Key Baru
                </p>
                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Simpan API key ini sekarang. Setelah halaman ditutup atau di-refresh, API key tidak dapat ditampilkan lagi.
                </p>

                <div class="mt-4 overflow-x-auto rounded-lg bg-white p-4 ring-1 ring-amber-200">
                    <code class="text-sm font-semibold text-slate-950">
                        {{ session('generated_api_key') }}
                    </code>
                </div>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                            {{ strtoupper($device->type) }}
                        </p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-950">
                            {{ $device->device_code }}
                        </h2>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ $device->name }}
                        </p>
                    </div>

                    @php
                        $statusClass = match ($device->status) {
                            'active' => 'bg-emerald-100 text-emerald-700',
                            'inactive' => 'bg-slate-100 text-slate-600',
                            'maintenance' => 'bg-amber-100 text-amber-700',
                            default => 'bg-slate-100 text-slate-600',
                        };
                    @endphp

                    <span class="inline-flex rounded-lg px-3 py-1 text-xs font-semibold uppercase {{ $statusClass }}">
                        {{ $device->status }}
                    </span>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $device->location_name ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Last Seen</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $device->last_seen_at?->diffForHumans() ?? 'Belum pernah aktif' }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Latitude</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $device->latitude ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Longitude</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $device->longitude ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">
                    Aksi Device
                </h3>

                <div class="mt-5 space-y-3">
                    <a href="{{ route('admin.devices.edit', $device) }}"
                       class="block rounded-lg bg-green-700 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-green-800">
                        Edit Device
                    </a>

                    <form method="POST" action="{{ route('admin.devices.toggle-status', $device) }}">
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            {{ $device->status === 'active' ? 'Nonaktifkan Device' : 'Aktifkan Device' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.devices.rotate-key', $device) }}">
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            onclick="return confirm('Reset API key? API key lama tidak akan bisa digunakan lagi.')"
                            class="w-full rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 transition hover:bg-amber-100"
                        >
                            Reset API Key
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.devices.destroy', $device) }}">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            onclick="return confirm('Hapus device ini? Device yang sudah memiliki data monitoring tidak dapat dihapus.')"
                            class="w-full rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                        >
                            Hapus Device
                        </button>
                    </form>

                    <a href="{{ route('admin.devices.index') }}"
                       class="block rounded-lg border border-slate-200 bg-white px-4 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">
                Konfigurasi Header API
            </h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Gunakan header berikut saat perangkat IoT mengirim data ke endpoint API.
            </p>

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        X-Device-Code
                    </p>
                    <code class="mt-2 block text-sm font-bold text-slate-950">
                        {{ $device->device_code }}
                    </code>
                </div>

                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        X-Device-Key
                    </p>
                    <p class="mt-2 text-sm font-semibold text-slate-700">
                        Hanya tampil saat device dibuat atau API key di-reset.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="text-lg font-bold text-slate-950">Riwayat Tanah Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">10 data monitoring tanah terakhir dari device ini.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-5 py-3">Waktu</th>
                                <th class="px-5 py-3">pH</th>
                                <th class="px-5 py-3">Moisture</th>
                                <th class="px-5 py-3">EC</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($soilReadings as $reading)
                                <tr>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->recorded_at?->format('d M Y H:i') }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->ph ?? '-' }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->moisture ?? '-' }}%</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->ec ?? '-' }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ strtoupper($reading->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-500">
                                        Belum ada data tanah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="text-lg font-bold text-slate-950">Riwayat Air Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">10 data monitoring air terakhir dari device ini.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-5 py-3">Waktu</th>
                                <th class="px-5 py-3">pH</th>
                                <th class="px-5 py-3">TDS</th>
                                <th class="px-5 py-3">Battery</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($waterReadings as $reading)
                                <tr>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->recorded_at?->format('d M Y H:i') }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->ph ?? '-' }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->tds ?? '-' }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reading->battery ?? '-' }}%</td>
                                    <td class="px-5 py-4 text-slate-600">{{ strtoupper($reading->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-500">
                                        Belum ada data air.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-layouts.dashboard>