<x-layouts.dashboard title="Manajemen Transaksi">
    <x-slot name="header">
        Manajemen Transaksi
    </x-slot>

    <section class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Transaction Management</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950">Daftar Order</h2>
            <p class="mt-2 text-sm text-slate-600">
                Kelola pesanan, pembayaran, dan status pemrosesan tanpa modul ekspedisi penuh.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.index') }}" class="grid gap-4 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Order</label>
                    <input name="search" value="{{ $search }}"
                           placeholder="Cari kode order, nama pembeli, email, atau telepon"
                           class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                    <select name="status"
                            class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                        <option value="">Semua status</option>
                        @foreach (['waiting_payment', 'paid', 'processing', 'ready', 'completed', 'cancelled', 'expired'] as $option)
                            <option value="{{ $option }}" @selected($status === $option)>{{ str_replace('_', ' ', ucfirst($option)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 lg:col-span-3">
                    <button class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">Filter</button>
                    <a href="{{ route($routePrefix . '.index') }}"
                       class="rounded-lg border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Order</th>
                            <th class="px-5 py-4">Pembeli</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Pembayaran</th>
                            <th class="px-5 py-4">Total</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-bold text-slate-950">{{ $order->order_code }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-900">{{ $order->buyer?->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $order->buyer?->email }}</p>
                                </td>
                                <td class="px-5 py-4 uppercase text-slate-600">{{ str_replace('_', ' ', $order->status) }}</td>
                                <td class="px-5 py-4 uppercase text-slate-600">{{ $order->payment?->status ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    Rp{{ number_format((float) $order->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $order->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route($routePrefix . '.show', $order) }}"
                                       class="rounded-lg bg-green-700 px-4 py-2 text-xs font-semibold text-white hover:bg-green-800">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-500">Belum ada order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $orders->links() }}
            </div>
        </div>
    </section>
</x-layouts.dashboard>