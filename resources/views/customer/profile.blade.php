<x-layouts.app title="Profil Saya">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Profil Saya</h1>

    <div class="max-w-lg card">
        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="label">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input">
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
            </div>
            <div>
                <label class="label">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input">
            </div>
            <div>
                <label class="label">Foto Profil</label>
                <input type="file" name="avatar" accept="image/*" class="input">
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</x-layouts.app>
