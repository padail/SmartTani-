@php
    $address = $address ?? null;
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Label Alamat</label>
        <input name="label" value="{{ old('label', $address?->label ?? 'Alamat Utama') }}"
               class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10" required>
        @error('label') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Destination ID</label>
        <input name="destination_id" value="{{ old('destination_id', $address?->destination_id) }}"
               class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10" required>
        @error('destination_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Penerima</label>
        <input name="recipient_name" value="{{ old('recipient_name', $address?->recipient_name) }}"
               class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10" required>
        @error('recipient_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Telepon/WhatsApp</label>
        <input name="recipient_phone" value="{{ old('recipient_phone', $address?->recipient_phone) }}"
               class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10" required>
        @error('recipient_phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Label Tujuan</label>
        <input name="destination_label" value="{{ old('destination_label', $address?->destination_label) }}"
               placeholder="Contoh: Sampang, Jawa Timur"
               class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
        @error('destination_label') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat Lengkap</label>
        <textarea name="address" rows="4"
                  class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10" required>{{ old('address', $address?->address) }}</textarea>
        @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="lg:col-span-2">
        <label class="flex items-start gap-3 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
            <input type="checkbox" name="is_default" value="1"
                   class="mt-1 rounded border-slate-300 text-green-700 focus:ring-green-700"
                   @checked(old('is_default', $address?->is_default))>
            <span>
                <span class="block text-sm font-semibold text-slate-900">Jadikan alamat utama</span>
                <span class="block text-sm text-slate-500">Alamat utama akan dipilih otomatis saat checkout.</span>
            </span>
        </label>
    </div>
</div>