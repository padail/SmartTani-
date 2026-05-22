<x-layouts.public title="Beranda - Tani Monitoring">
    <section class="bg-gradient-to-br from-green-50 to-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-20 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="mb-3 text-sm font-semibold uppercase tracking-wide text-green-700">
                    Smart Farming & Marketplace
                </p>

                <h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-5xl">
                    Monitoring Pertanian Real-Time dan Penjualan Produk Tani
                </h1>

                <p class="mt-5 max-w-xl text-base leading-7 text-slate-600">
                    Platform untuk memantau kondisi tanah dan air secara real-time, sekaligus mendukung pemasaran dan transaksi produk pertanian kelompok tani.
                </p>

                <div class="mt-8 flex gap-3">
                    <a href="{{ url('/register') }}" class="rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800">
                        Mulai Belanja
                    </a>

                    <a href="#" class="rounded-lg border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Lihat Produk
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-green-100 bg-white p-6 shadow-sm">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-green-50 p-5">
                        <p class="text-sm font-medium text-green-700">Monitoring Tanah</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Real-Time</p>
                        <p class="mt-1 text-sm text-slate-600">NPK, pH, EC, moisture, suhu</p>
                    </div>

                    <div class="rounded-2xl bg-blue-50 p-5">
                        <p class="text-sm font-medium text-blue-700">Monitoring Air</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Sensor Data</p>
                        <p class="mt-1 text-sm text-slate-600">pH, TDS, EC, battery</p>
                    </div>

                    <div class="rounded-2xl bg-orange-50 p-5">
                        <p class="text-sm font-medium text-orange-700">Marketplace</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Produk Tani</p>
                        <p class="mt-1 text-sm text-slate-600">Katalog, checkout, pembayaran</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm font-medium text-slate-700">Dashboard</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Admin</p>
                        <p class="mt-1 text-sm text-slate-600">User, konten, laporan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>