<x-layouts.auth title="Login">
    <h2 class="mb-6 text-xl font-semibold text-slate-800">Masuk ke Akun</h2>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">
                Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
            >
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">
                Password
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
            >
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-green-600">
                Ingat saya
            </label>

            <a href="{{ url('/forgot-password') }}" class="text-sm font-medium text-green-700 hover:text-green-800">
                Lupa password?
            </a>
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-800"
        >
            Login
        </button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-600">
        Belum punya akun?
        <a href="{{ url('/register') }}" class="font-medium text-green-700 hover:text-green-800">
            Daftar
        </a>
    </p>
</x-layouts.auth>