<x-layouts.dashboard title="Dashboard Pembeli">
    <x-slot name="header">
        Dashboard Pembeli
    </x-slot>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Pesanan Saya</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">0</p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Menunggu Pembayaran</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">0</p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Review Produk</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">0</p>
        </div>
    </div>
</x-layouts.dashboard>