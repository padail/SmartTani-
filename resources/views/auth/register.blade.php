<x-layouts.auth title="Register">
    <h2 class="mb-6 text-xl font-semibold text-slate-800">Daftar Akun Pembeli</h2>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">
                Nama Lengkap
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
            >
        </div>

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
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
            >
        </div>

        <div>
            <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">
                Nomor WhatsApp
            </label>
            <input
                id="phone"
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="08xxxxxxxxxx"
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

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">
                Konfirmasi Password
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-800"
        >
            Daftar
        </button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-600">
        Sudah punya akun?
        <a href="{{ url('/login') }}" class="font-medium text-green-700 hover:text-green-800">
            Login
        </a>
    </p>
</x-layouts.auth>