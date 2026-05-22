<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex h-screen w-72 -translate-x-full flex-col border-r border-slate-200 bg-white shadow-sm transition-all duration-300 lg:translate-x-0 lg:w-72">
    <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 px-5">
        <a href="{{ route('home') }}" class="sidebar-brand flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-700 text-xs font-bold text-white">
                TM
            </div>

            <div class="sidebar-label">
                <p class="text-sm font-bold text-slate-950">
                    Tani Monitoring
                </p>
                <p class="text-xs text-slate-500">
                    Smart Farming AIoT
                </p>
            </div>
        </a>

        <button
            type="button"
            id="sidebarCloseMobile"
            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden"
            aria-label="Tutup menu">
            ✕
        </button>
    </div>
    <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @auth
        @if (auth()->user()->role === 'admin')
        <a
            href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
            <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▦</span>
            <span class="sidebar-label">Dashboard Admin</span>
        </a>

        @if (Route::has('monitoring.dashboard'))
        <a
            href="{{ route('monitoring.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('monitoring.*') ? 'bg-green-700 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
            <span class="sidebar-icon flex h-6 w-6 items-center justify-center">◉</span>
            <span class="sidebar-label">Monitoring</span>
        </a>
        @endif

        <div class="pt-4">
            <p class="sidebar-label px-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Manajemen
            </p>

            <div class="mt-2 space-y-1">
                <a href="#" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">👥</span>
                    <span class="sidebar-label">Manajemen User</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▣</span>
                    <span class="sidebar-label">Manajemen Produk</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">↔</span>
                    <span class="sidebar-label">Transaksi</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▤</span>
                    <span class="sidebar-label">Manajemen Konten</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▥</span>
                    <span class="sidebar-label">Laporan</span>
                </a>
            </div>
        </div>
        @elseif (auth()->user()->role === 'owner')
        <a
            href="{{ route('owner.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('owner.dashboard') ? 'bg-green-700 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
            <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▦</span>
            <span class="sidebar-label">Dashboard Owner</span>
        </a>

        @if (Route::has('monitoring.dashboard'))
        <a
            href="{{ route('monitoring.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('monitoring.*') ? 'bg-green-700 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
            <span class="sidebar-icon flex h-6 w-6 items-center justify-center">◉</span>
            <span class="sidebar-label">Monitoring</span>
        </a>
        @endif

        <div class="pt-4">
            <p class="sidebar-label px-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Penjualan
            </p>

            <div class="mt-2 space-y-1">
                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▣</span>
                    <span class="sidebar-label">Manajemen Produk</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▤</span>
                    <span class="sidebar-label">Kelola Pesanan</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">◎</span>
                    <span class="sidebar-label">Kelola Pembayaran</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">☏</span>
                    <span class="sidebar-label">Chat Pembeli</span>
                </a>
            </div>
        </div>
        @elseif (auth()->user()->role === 'buyer')
        <a
            href="{{ route('buyer.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'bg-green-700 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition">
            <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▦</span>
            <span class="sidebar-label">Dashboard Pembeli</span>
        </a>

        <div class="pt-4">
            <p class="sidebar-label px-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
                Belanja
            </p>

            <div class="mt-2 space-y-1">
                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">▣</span>
                    <span class="sidebar-label">Katalog Produk</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">◫</span>
                    <span class="sidebar-label">Keranjang</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">⇄</span>
                    <span class="sidebar-label">Tracking Pesanan</span>
                </a>

                <a href="#" class="sidebar-link flex items-center gap-3 rounded px-4 py-3 text-sm font-semibold text-slate-400">
                    <span class="sidebar-icon flex h-6 w-6 items-center justify-center">☆</span>
                    <span class="sidebar-label">Review Produk</span>
                </a>
            </div>
        </div>
        @endif
        @endauth
    </nav>

    <div class="shrink-0 border-t border-slate-200 p-3">
        <div class="sidebar-user-card rounded-xl p-3 ">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-700 text-sm font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <div class="sidebar-label min-w-0">
                    <p class="truncate text-sm font-bold text-slate-950">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>
                    <p class="truncate text-xs capitalize text-slate-500">
                        {{ auth()->user()->role ?? '-' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="sidebar-label mt-3">
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>