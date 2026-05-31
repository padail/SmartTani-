<x-layouts.dashboard title="Ringkasan Order">
    <x-slot name="header">
        Ringkasan Order
    </x-slot>

    @php
        $trackingSteps = [
            'waiting_payment' => 'Menunggu Pembayaran',
            'paid' => 'Pembayaran Berhasil',
            'processing' => 'Pesanan Diproses',
            'ready' => 'Pesanan Siap',
            'completed' => 'Selesai',
        ];

        $currentIndex = array_search($order->status, array_keys($trackingSteps), true);
        $currentIndex = $currentIndex === false ? -1 : $currentIndex;
    @endphp

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

        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Invoice</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950">{{ $order->order_code }}</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Status: <span class="font-bold uppercase text-slate-950">{{ str_replace('_', ' ', $order->status) }}</span>
                </p>
            </div>

            <a href="{{ route('buyer.orders.index') }}"
               class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Kembali ke Pesanan
            </a>
        </div>

        @if (in_array($order->status, ['pending', 'waiting_payment'], true))
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">
                            Arahan Pembayaran
                        </p>
                        <h3 class="mt-1 text-xl font-bold text-slate-950">
                            Pesanan sudah dibuat, tetapi belum dibayar
                        </h3>
                        <ol class="mt-3 list-decimal space-y-1 pl-5 text-sm leading-6 text-amber-800">
                            <li>Klik tombol <strong>Bayar Sekarang</strong>.</li>
                            <li>Pilih metode pembayaran pada popup Midtrans.</li>
                            <li>Selesaikan pembayaran sesuai instruksi Midtrans.</li>
                            <li>Status pesanan akan berubah setelah notifikasi pembayaran diterima sistem.</li>
                        </ol>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if ($order->payment?->snap_token)
                            <button
                                type="button"
                                id="payButton"
                                class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                                Bayar Sekarang
                            </button>
                        @else
                            <form method="POST" action="{{ route('buyer.orders.refresh-payment', $order) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                                    Buat Ulang Token Pembayaran
                                </button>
                            </form>
                        @endif

                        <p class="max-w-xs text-xs leading-5 text-amber-800">
                            Jika popup tidak muncul, pastikan browser tidak memblokir script pembayaran.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-950">Tracking Pesanan</h3>

            <div class="mt-6 grid gap-4 md:grid-cols-5">
                @foreach ($trackingSteps as $stepStatus => $label)
                    @php
                        $stepIndex = array_search($stepStatus, array_keys($trackingSteps), true);
                        $isDone = $currentIndex >= $stepIndex;
                    @endphp

                    <div class="rounded-xl p-4 ring-1 {{ $isDone ? 'bg-green-50 text-green-700 ring-green-100' : 'bg-slate-50 text-slate-500 ring-slate-200' }}">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg {{ $isDone ? 'bg-green-700 text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $stepIndex + 1 }}
                        </div>
                        <p class="mt-3 text-sm font-bold">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            @if (in_array($order->status, ['cancelled', 'expired'], true))
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    Pesanan berstatus {{ strtoupper($order->status) }}.
                </div>
            @endif
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="text-lg font-bold text-slate-950">Item Pesanan</h3>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach ($order->items as $item)
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

            <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:self-start">
                <h3 class="text-lg font-bold text-slate-950">Ringkasan Pembayaran</h3>

                <div class="mt-5 space-y-3 text-sm">
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

                <div class="mt-6 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Pembayaran</p>
                    <p class="mt-2 text-sm font-bold uppercase text-slate-950">{{ $order->payment?->status ?? '-' }}</p>
                    <p class="mt-1 text-sm text-slate-500">Gateway: {{ $order->payment?->payment_gateway ?? '-' }}</p>
                </div>
            </aside>
        </div>
    </section>

    @if ($order->payment?->snap_token)
        <script src="{{ $snapUrl }}" data-client-key="{{ $midtransClientKey }}"></script>

        <script>
            const payButton = document.getElementById('payButton');

            payButton?.addEventListener('click', () => {
                window.snap.pay("{{ $order->payment->snap_token }}", {
                    onSuccess: function () {
                        window.location.reload();
                    },
                    onPending: function () {
                        window.location.reload();
                    },
                    onError: function () {
                        alert('Pembayaran gagal diproses.');
                    },
                    onClose: function () {
                        console.log('Pembeli menutup popup pembayaran.');
                    }
                });
            });
        </script>
    @endif
</x-layouts.dashboard>