<footer class="mt-auto border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-6 py-8">
        <div class="grid gap-8 lg:grid-cols-3 lg:items-center">
            
            {{-- Brand / Deskripsi Sistem --}}
            <div class="lg:col-span-1">
                <h2 class="text-lg font-bold text-green-700">
                    Tani Monitoring
                </h2>

                <p class="mt-2 max-w-md text-sm leading-6 text-slate-600">
                    Sistem monitoring kualitas tanah dan air berbasis AIoT serta platform digital pemasaran produk pertanian.
                </p>
            </div>

            {{-- Space Logo Instansi --}}
            <div class="lg:col-span-1">
                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Didukung oleh
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    {{-- Logo Instansi 1 --}}
                    <div class="flex h-25 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4">
                        <img
                            src="{{ asset('images/instansi/logo-instansi-1.png') }}"
                            alt="Logo Instansi 1"
                            class="max-h-22 max-w-full object-contain"
                        >
                    </div>

                    {{-- Logo Instansi 2 --}}
                    <div class="flex h-25 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4">
                        <img
                            src="{{ asset('images/instansi/logo-instansi-2.png') }}"
                            alt="Logo Instansi 2"
                            class="max-h-22 max-w-full object-contain"
                        >
                    </div>
                </div>
            </div>

            {{-- Kontak Ringkas --}}
            <div class="lg:col-span-1 lg:text-right">
                <p class="text-sm font-semibold text-slate-700">
                    Kontak
                </p>

                <div class="mt-2 space-y-1 text-sm text-slate-600">
                    <p>Kelompok Tani Banyu Urip</p>
                    <p>Desa Tanggumong, Kecamatan Sampang</p>
                    <p class="text-green-700">Monitoring & Marketplace Melon</p>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-5">
            <div class="flex flex-col gap-2 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>
                    © {{ date('Y') }} Tani Monitoring. All rights reserved.
                </p>

                <p>
                    Smart Farming • AIoT • Digital Marketplace
                </p>
            </div>
        </div>
    </div>
</footer>