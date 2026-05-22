<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Authentication' }} - Tani Monitoring</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-green-700">Tani Monitoring</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Monitoring pertanian dan transaksi produk tani
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>
</html>