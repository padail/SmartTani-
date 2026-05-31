<x-layouts.dashboard title="Detail Transaksi">
    <x-slot name="header">
        Detail Transaksi
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

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Order</p>
                    <h2 class="mt-1 text-2xl font-bold text-slate-950">{{ $order->order_code }}</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Pembeli: <span class="font-semibold text-slate-950">{{ $order->buyer?->name }}</span>
                    </p>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="text-lg font-bold text-slate-950">Item Pesanan</h3>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach ($visibleItems as $item)
                            <div class="flex justify-between gap-4 p-5">
                                <div>
                                    <p class="font-bold text-slate-950">{{ $item->product_name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $item->quantity }} {{ $item->unit }} × Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <p class="font-bold text-slate-950">
                                    Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">Data Pengiriman</h3>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Penerima</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">{{ $order->recipient_name }}</p>
                            <p class="text-sm text-slate-500">{{ $order->recipient_phone }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kurir</p>
                            <p class="mt-2 text-sm font-bold text-slate-950">
                                {{ strtoupper($order->shipping_courier ?? '-') }} - {{ $order->shipping_service ?? '-' }}
                            </p>
                            <p class="text-sm text-slate-500">Estimasi {{ $order->shipping_etd ?? '-' }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200 sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Alamat</p>
                            <p class="mt-2 text-sm leading-6 text-slate-700">{{ $order->shipping_address }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $order->destination_label ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">Update Status</h3>

                    <form method="POST" action="{{ route($routePrefix . '.update-status', $order) }}" class="mt-5 space-y-4">
                        @csrf
                        @method('PATCH')

                        <select name="status"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                            @foreach (['waiting_payment', 'paid', 'processing', 'ready', 'completed', 'cancelled', 'expired'] as $option)
                                <option value="{{ $option }}" @selected($order->status === $option)>
                                    {{ str_replace('_', ' ', ucfirst($option)) }}
                                </option>
                            @endforeach
                        </select>

                        <button class="w-full rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">
                            Simpan Status
                        </button>
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">Ringkasan</h3>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status</span>
                            <span class="font-semibold uppercase text-slate-900">{{ str_replace('_', ' ', $order->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Pembayaran</span>
                            <span class="font-semibold uppercase text-slate-900">{{ $order->payment?->status ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-semibold text-slate-900">Rp{{ number_format((float) $order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Ongkir</span>
                            <span class="font-semibold text-slate-900">Rp{{ number_format((float) $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-3">
                            <span class="font-bold text-slate-950">Total</span>
                            <span class="font-bold text-slate-950">Rp{{ number_format((float) $order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route($routePrefix . '.index') }}"
                   class="block rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
            </aside>
        </div>
    </section>
</x-layouts.dashboard>