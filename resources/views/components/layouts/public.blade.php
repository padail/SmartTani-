<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tani Monitoring' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="text-lg font-bold text-green-700">
                Tani Monitoring
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                <a href="#" class="hover:text-green-700">Profil</a>
                <a href="#" class="hover:text-green-700">Budidaya Melon</a>
                <a href="#" class="hover:text-green-700">Produk</a>
                <a href="#" class="hover:text-green-700">Galeri</a>
                <a href="#" class="hover:text-green-700">Kontak</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">
                        Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="text-sm font-medium text-slate-700 hover:text-green-700">
                        Login
                    </a>
                    <a href="{{ url('/register') }}" class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
    <x-layouts.footer />
</body>
</html>