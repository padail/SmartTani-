<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tani Monitoring' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Sistem monitoring AIoT dan marketplace produk pertanian kelompok tani.' }}">
    <meta property="og:title" content="{{ $title ?? 'Tani Monitoring' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Sistem monitoring AIoT dan marketplace produk pertanian kelompok tani.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-700 text-xs font-bold text-white">
                    TM
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-950">Tani Monitoring</p>
                    <p class="text-xs text-slate-500">Smart Farming AIoT</p>
                </div>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                <a href="{{ route('home') }}" class="hover:text-green-700">Beranda</a>
                <a href="{{ route('public.products.index') }}" class="hover:text-green-700">Produk</a>
                <a href="#" class="hover:text-green-700">Profil Kelompok Tani</a>
                <a href="#" class="hover:text-green-700">Galeri</a>
                <a href="#" class="hover:text-green-700">Kontak</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-800">
                        Dashboard
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Login
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-800 sm:inline-flex">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-layouts.footer />
</body>

</html>