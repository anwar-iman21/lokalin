<x-layouts.guest title="Daftar">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('landing') }}" class="text-2xl font-extrabold text-primary-600">LOKALIN</a>
                <p class="mt-2 text-sm text-gray-500">Buat akun baru</p>
            </div>

            <div class="card">
                @include('components.flash')

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="label" for="name">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="input">
                    </div>
                    <div>
                        <label class="label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input">
                    </div>
                    <div>
                        <label class="label" for="phone">Nomor HP</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="input">
                    </div>
                    <div>
                        <label class="label">Daftar sebagai</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 p-3 text-sm has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                                <input type="radio" name="role" value="customer" class="text-primary-600" {{ old('role', 'customer') == 'customer' ? 'checked' : '' }}>
                                Pelanggan
                            </label>
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 p-3 text-sm has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                                <input type="radio" name="role" value="umkm" class="text-primary-600" {{ old('role') == 'umkm' ? 'checked' : '' }}>
                                Pemilik UMKM
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="label" for="password">Kata Sandi</label>
                        <input id="password" type="password" name="password" required class="input">
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="input">
                    </div>
                    <button type="submit" class="btn-primary w-full">Daftar</button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest>
