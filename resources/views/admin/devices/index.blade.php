<x-layouts.dashboard title="Manajemen Device">
    <x-slot name="header">
        Manajemen Device IoT
    </x-slot>

    <section class="space-y-6">
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                    Device Management
                </p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950">
                    Perangkat Monitoring Tanah dan Air
                </h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                    Kelola perangkat IoT, status koneksi, tipe sensor, dan API key untuk pengiriman data monitoring.
                </p>
            </div>

            <a href="{{ route('admin.devices.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800">
                + Tambah Device
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
            <form method="GET" action="{{ route('admin.devices.index') }}" class="grid gap-4 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                        Cari Device
                    </label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Cari kode, nama, atau lokasi device"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                    >
                </div>

                <div>
                    <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tipe
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                    >
                        <option value="">Semua tipe</option>
                        <option value="soil" @selected($type === 'soil')>Tanah</option>
                        <option value="water" @selected($type === 'water')>Air</option>
                        <option value="mixed" @selected($type === 'mixed')>Mixed</option>
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
                        <option value="active" @selected($status === 'active')>Active</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                        <option value="maintenance" @selected($status === 'maintenance')>Maintenance</option>
                    </select>
                </div>

                <div class="flex items-end gap-3 lg:col-span-4">
                    <button
                        type="submit"
                        class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800"
                    >
                        Filter
                    </button>

                    <a href="{{ route('admin.devices.index') }}"
                       class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
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
                            <th class="px-5 py-4">Device</th>
                            <th class="px-5 py-4">Tipe</th>
                            <th class="px-5 py-4">Lokasi</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Last Seen</th>
                            <th class="px-5 py-4">Data</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($devices as $device)
                            @php
                                $statusClass = match ($device->status) {
                                    'active' => 'bg-emerald-100 text-emerald-700',
                                    'inactive' => 'bg-slate-100 text-slate-600',
                                    'maintenance' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-950">
                                        {{ $device->device_code }}
                                    </p>
                                    <p class="mt-1 text-slate-500">
                                        {{ $device->name }}
                                    </p>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold uppercase text-slate-600">
                                        {{ $device->type }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $device->location_name ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-lg px-3 py-1 text-xs font-semibold uppercase {{ $statusClass }}">
                                        {{ $device->status }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $device->last_seen_at?->diffForHumans() ?? 'Belum pernah aktif' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    <div>Tanah: {{ $device->soil_readings_count }}</div>
                                    <div>Air: {{ $device->water_readings_count }}</div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.devices.show', $device) }}"
                                           class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.devices.edit', $device) }}"
                                           class="rounded-lg bg-green-700 px-3 py-2 text-xs font-semibold text-white hover:bg-green-800">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada device yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $devices->links() }}
            </div>
        </div>
    </section>
</x-layouts.dashboard>