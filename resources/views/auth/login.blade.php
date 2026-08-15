<x-layouts.guest title="Masuk">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('landing') }}" class="text-2xl font-extrabold text-primary-600">LOKALIN</a>
                <p class="mt-2 text-sm text-gray-500">Masuk untuk melanjutkan</p>
            </div>

            <div class="card">
                @include('components.flash')

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input">
                    </div>
                    <div>
                        <label class="label" for="password">Kata Sandi</label>
                        <input id="password" type="password" name="password" required class="input">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600">
                        Ingat saya
                    </label>
                    <button type="submit" class="btn-primary w-full">Masuk</button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:underline">Daftar sekarang</a>
                </p>
            </div>

            <div class="mt-6 rounded-xl bg-amber-50 border border-amber-200 p-4 text-xs text-amber-800">
                <p class="font-semibold mb-1">Akun Demo (untuk keperluan penilaian):</p>
                <p>Admin: admin@lokalin.test / password</p>
                <p>Pelanggan: customer@lokalin.test / password</p>
                <p>UMKM: umkm1@lokalin.test / password</p>
            </div>
        </div>
    </div>
</x-layouts.guest>
