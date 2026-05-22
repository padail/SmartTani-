@php
    $device = $device ?? null;
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="device_code" class="mb-2 block text-sm font-semibold text-slate-700">
            Kode Device
        </label>
        <input
            id="device_code"
            name="device_code"
            type="text"
            value="{{ old('device_code', $device?->device_code) }}"
            placeholder="Contoh: SOIL-001"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
            required
        >
        @error('device_code')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Device
        </label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $device?->name) }}"
            placeholder="Contoh: Sensor Tanah Lahan Melon 1"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
            required
        >
        @error('name')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">
            Tipe Device
        </label>
        <select
            id="type"
            name="type"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
            required
        >
            <option value="soil" @selected(old('type', $device?->type) === 'soil')>Monitoring Tanah</option>
            <option value="water" @selected(old('type', $device?->type) === 'water')>Monitoring Air</option>
            <option value="mixed" @selected(old('type', $device?->type) === 'mixed')>Tanah dan Air</option>
        </select>
        @error('type')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">
            Status Device
        </label>
        <select
            id="status"
            name="status"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
            required
        >
            <option value="active" @selected(old('status', $device?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $device?->status) === 'inactive')>Inactive</option>
            <option value="maintenance" @selected(old('status', $device?->status) === 'maintenance')>Maintenance</option>
        </select>
        @error('status')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label for="location_name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Lokasi
        </label>
        <input
            id="location_name"
            name="location_name"
            type="text"
            value="{{ old('location_name', $device?->location_name) }}"
            placeholder="Contoh: Lahan Melon Desa Tanggumong"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
        >
        @error('location_name')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="latitude" class="mb-2 block text-sm font-semibold text-slate-700">
            Latitude
        </label>
        <input
            id="latitude"
            name="latitude"
            type="number"
            step="0.0000001"
            value="{{ old('latitude', $device?->latitude) }}"
            placeholder="-7.1970000"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
        >
        @error('latitude')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="longitude" class="mb-2 block text-sm font-semibold text-slate-700">
            Longitude
        </label>
        <input
            id="longitude"
            name="longitude"
            type="number"
            step="0.0000001"
            value="{{ old('longitude', $device?->longitude) }}"
            placeholder="113.2390000"
            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
        >
        @error('longitude')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>