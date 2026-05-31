<x-layouts.dashboard title="Pesanan Saya">
    <x-slot name="header">
        Pesanan Saya
    </x-slot>

    <section class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Order Tracking</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950">Daftar Pesanan</h2>
            <p class="mt-2 text-sm text-slate-600">
                Pantau status pembayaran dan proses pesanan.
            </p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Order</th>
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
                                <td class="px-5 py-4 uppercase text-slate-600">{{ str_replace('_', ' ', $order->status) }}</td>
                                <td class="px-5 py-4 uppercase text-slate-600">{{ $order->payment?->status ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    Rp{{ number_format((float) $order->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $order->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('buyer.orders.show', $order) }}"
                                       class="rounded-lg bg-green-700 px-4 py-2 text-xs font-semibold text-white hover:bg-green-800">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada pesanan.
                                </td>
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