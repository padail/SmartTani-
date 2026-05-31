<x-layouts.dashboard title="Checkout">
    <x-slot name="header">
        Checkout
    </x-slot>

    <section class="space-y-6">
        @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <p class="font-bold">Checkout belum bisa diproses.</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                Checkout
            </p>
            <h2 class="mt-1 text-2xl font-bold text-slate-950">
                Data Pengiriman dan Ringkasan Order
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Isi alamat tujuan, hitung estimasi ongkos kirim, lalu lanjutkan pembayaran melalui Midtrans.
            </p>
        </div>

        <form method="POST" action="{{ route('buyer.checkout.store') }}" class="grid gap-6 lg:grid-cols-3">
            @csrf

            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">
                        Data Penerima
                    </h3>
                    @if ($addresses->isNotEmpty())
                    <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <label for="buyer_address_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Pilih Alamat Tersimpan
                        </label>

                        <select
                            id="buyer_address_id"
                            name="buyer_address_id"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                            <option value="">Input alamat baru</option>
                            @foreach ($addresses as $address)
                            <option
                                value="{{ $address->id }}"
                                data-recipient-name="{{ $address->recipient_name }}"
                                data-recipient-phone="{{ $address->recipient_phone }}"
                                data-address="{{ $address->address }}"
                                data-destination-id="{{ $address->destination_id }}"
                                data-destination-label="{{ $address->destination_label }}"
                                @selected($address->is_default)
                                >
                                {{ $address->label }} — {{ $address->destination_label ?? $address->address }}
                                {{ $address->is_default ? '(Utama)' : '' }}
                            </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            Pilih alamat agar data penerima dan tujuan otomatis terisi.
                        </p>
                    </div>
                    @endif
                    <div class="mt-5 grid gap-5 lg:grid-cols-2">
                        <div>
                            <label for="recipient_name" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nama Penerima
                            </label>
                            <input
                                id="recipient_name"
                                name="recipient_name"
                                type="text"
                                value="{{ old('recipient_name', auth()->user()->name) }}"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                                required>
                        </div>

                        <div>
                            <label for="recipient_phone" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nomor WhatsApp/Telepon
                            </label>
                            <input
                                id="recipient_phone"
                                name="recipient_phone"
                                type="text"
                                value="{{ old('recipient_phone', auth()->user()->phone) }}"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                                required>
                        </div>

                        <div class="lg:col-span-2">
                            <label for="shipping_address" class="mb-2 block text-sm font-semibold text-slate-700">
                                Alamat Lengkap
                            </label>
                            <textarea
                                id="shipping_address"
                                name="shipping_address"
                                rows="4"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                                required>{{ old('shipping_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-950">
                        Estimasi Ongkos Kirim
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Untuk tahap awal, masukkan ID district/kecamatan tujuan dari RajaOngkir. Tahap berikutnya bisa ditingkatkan menjadi dropdown pencarian provinsi/kota/kecamatan.
                    </p>

                    <div class="mt-5 grid gap-5 lg:grid-cols-3">
                        <div>
                            <label for="destination_id" class="mb-2 block text-sm font-semibold text-slate-700">
                                Destination District ID
                            </label>
                            <input
                                id="destination_id"
                                name="destination_id"
                                type="text"
                                value="{{ old('destination_id') }}"
                                placeholder="Contoh: 1376"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10"
                                required>
                        </div>

                        <div>
                            <label for="destination_label" class="mb-2 block text-sm font-semibold text-slate-700">
                                Label Tujuan
                            </label>
                            <input
                                id="destination_label"
                                name="destination_label"
                                type="text"
                                value="{{ old('destination_label') }}"
                                placeholder="Contoh: Sampang, Jawa Timur"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                        </div>

                        <div>
                            <label for="courier" class="mb-2 block text-sm font-semibold text-slate-700">
                                Kurir
                            </label>
                            <select
                                id="courier"
                                class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">
                                <option value="jne">JNE</option>
                                <option value="sicepat">SiCepat</option>
                                <option value="jnt">J&T</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS</option>
                            </select>
                        </div>
                    </div>

                    <button
                        type="button"
                        id="calculateShippingButton"
                        class="mt-5 rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                        Hitung Ongkir
                    </button>

                    <div id="shippingOptions" class="mt-5 space-y-3"></div>

                    <input type="hidden" name="shipping_courier" id="shipping_courier" value="{{ old('shipping_courier') }}">
                    <input type="hidden" name="shipping_service" id="shipping_service" value="{{ old('shipping_service') }}">
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost') }}">
                    <input type="hidden" name="shipping_etd" id="shipping_etd" value="{{ old('shipping_etd') }}">
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">
                        Catatan Pesanan
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="3"
                        placeholder="Contoh: mohon pilih buah yang siap konsumsi."
                        class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700/10">{{ old('notes') }}</textarea>
                </div>
            </div>

            <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:self-start">
                <h3 class="text-lg font-bold text-slate-950">
                    Ringkasan Order
                </h3>

                <div class="mt-5 space-y-4">
                    @foreach ($cart->items as $item)
                    <div class="flex justify-between gap-4 text-sm">
                        <div>
                            <p class="font-semibold text-slate-900">
                                {{ $item->product?->name }}
                            </p>
                            <p class="text-slate-500">
                                {{ $item->quantity }} × Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="font-semibold text-slate-900">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 space-y-3 border-t border-slate-200 pt-5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-semibold text-slate-900">
                            Rp{{ number_format($cart->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Berat</span>
                        <span class="font-semibold text-slate-900">
                            {{ number_format($cart->total_weight_gram) }} gram
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Ongkir</span>
                        <span id="shippingCostPreview" class="font-semibold text-slate-900">
                            Rp0
                        </span>
                    </div>

                    <div class="flex justify-between border-t border-slate-200 pt-3">
                        <span class="font-bold text-slate-900">Total</span>
                        <span id="grandTotalPreview" class="font-bold text-slate-950">
                            Rp{{ number_format($cart->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-6 w-full rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                    Buat Order & Bayar
                </button>

                <a
                    href="{{ route('buyer.cart.index') }}"
                    class="mt-3 block rounded-lg border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Kembali ke Keranjang
                </a>
            </aside>
        </form>
    </section>

    <script>
        const buyerAddressSelect = document.getElementById('buyer_address_id');

function applySelectedAddress() {
    const selected = buyerAddressSelect?.selectedOptions?.[0];

    if (!selected || !selected.value) {
        return;
    }

    document.getElementById('recipient_name').value = selected.dataset.recipientName || '';
    document.getElementById('recipient_phone').value = selected.dataset.recipientPhone || '';
    document.getElementById('shipping_address').value = selected.dataset.address || '';
    document.getElementById('destination_id').value = selected.dataset.destinationId || '';
    document.getElementById('destination_label').value = selected.dataset.destinationLabel || '';
}

buyerAddressSelect?.addEventListener('change', applySelectedAddress);
applySelectedAddress();

        const subtotal = {{(int) $cart->subtotal}};
        const calculateUrl = "{{ route('buyer.checkout.shipping-rate') }}";
        const csrfToken = "{{ csrf_token() }}";

        const calculateButton = document.getElementById('calculateShippingButton');
        const shippingOptions = document.getElementById('shippingOptions');

        const shippingCourierInput = document.getElementById('shipping_courier');
        const shippingServiceInput = document.getElementById('shipping_service');
        const shippingCostInput = document.getElementById('shipping_cost');
        const shippingEtdInput = document.getElementById('shipping_etd');

        const shippingCostPreview = document.getElementById('shippingCostPreview');
        const grandTotalPreview = document.getElementById('grandTotalPreview');

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function setSelectedRate(rate) {
            shippingCourierInput.value = rate.courier;
            shippingServiceInput.value = rate.service;
            shippingCostInput.value = rate.cost;
            shippingEtdInput.value = rate.etd ?? '';

            shippingCostPreview.textContent = formatRupiah(rate.cost);
            grandTotalPreview.textContent = formatRupiah(subtotal + Number(rate.cost));
        }

        calculateButton?.addEventListener('click', async () => {
            const destinationId = document.getElementById('destination_id').value;
            const courier = document.getElementById('courier').value;

            if (!destinationId) {
                alert('Destination District ID wajib diisi.');
                return;
            }

            shippingOptions.innerHTML = `
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Menghitung ongkos kirim...
                </div>
            `;

            const response = await fetch(calculateUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    destination_id: destinationId,
                    courier: courier,
                }),
            });

            const result = await response.json();
            const rates = result.data ?? [];

            if (!rates.length) {
                shippingOptions.innerHTML = `
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
                        Ongkos kirim tidak ditemukan.
                    </div>
                `;
                return;
            }

            shippingOptions.innerHTML = rates.map((rate, index) => `
                <label class="block cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-4 transition hover:border-green-700">
                    <div class="flex items-start gap-3">
                        <input
                            type="radio"
                            name="shipping_option_radio"
                            class="mt-1 text-green-700 focus:ring-green-700"
                            ${index === 0 ? 'checked' : ''}
                            data-rate='${JSON.stringify(rate)}'
                        >
                        <div class="flex-1">
                            <div class="flex flex-col justify-between gap-2 sm:flex-row">
                                <p class="font-bold text-slate-950">
                                    ${rate.courier.toUpperCase()} - ${rate.service}
                                </p>
                                <p class="font-bold text-green-700">
                                    ${formatRupiah(rate.cost)}
                                </p>
                            </div>
                            <p class="mt-1 text-sm text-slate-500">
                                ${rate.description ?? '-'} • Estimasi ${rate.etd ?? '-'}
                            </p>
                        </div>
                    </div>
                </label>
            `).join('');

            setSelectedRate(rates[0]);

            document.querySelectorAll('input[name="shipping_option_radio"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    setSelectedRate(JSON.parse(this.dataset.rate));
                });
            });
        });
    </script>
</x-layouts.dashboard>