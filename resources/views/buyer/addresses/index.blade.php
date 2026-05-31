<x-layouts.dashboard title="Alamat Saya">
    <x-slot name="header">
        Alamat Saya
    </x-slot>

    <section class="space-y-6">
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Address Book</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950">Alamat Pengiriman</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Simpan alamat agar checkout berikutnya tidak perlu input ulang.
                </p>
            </div>

            <a href="{{ route('buyer.addresses.create') }}"
               class="rounded-lg bg-green-700 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-green-800">
                + Tambah Alamat
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 lg:grid-cols-2">
            @forelse ($addresses as $address)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-slate-950">{{ $address->label }}</h3>

                                @if ($address->is_default)
                                    <span class="rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        Utama
                                    </span>
                                @endif
                            </div>

                            <p class="mt-2 text-sm font-semibold text-slate-900">{{ $address->recipient_name }}</p>
                            <p class="text-sm text-slate-500">{{ $address->recipient_phone }}</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-sm leading-6 text-slate-700">{{ $address->address }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            {{ $address->destination_label ?? '-' }}
                        </p>
                        <p class="text-xs text-slate-500">
                            Destination ID: {{ $address->destination_id }}
                        </p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('buyer.addresses.edit', $address) }}"
                           class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">
                            Edit
                        </a>

                        @if (! $address->is_default)
                            <form method="POST" action="{{ route('buyer.addresses.default', $address) }}">
                                @csrf
                                @method('PATCH')
                                <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    Jadikan Utama
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('buyer.addresses.destroy', $address) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('Hapus alamat ini?')"
                                class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm lg:col-span-2">
                    <p class="text-lg font-bold text-slate-950">Belum ada alamat</p>
                    <p class="mt-2 text-sm text-slate-600">Tambahkan alamat agar checkout lebih cepat.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-layouts.dashboard>