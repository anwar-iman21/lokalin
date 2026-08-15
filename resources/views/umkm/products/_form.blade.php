@php $product = $product ?? null; @endphp

<div>
    <label class="label">Nama Produk</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="input">
</div>

<div>
    <label class="label">Kategori</label>
    <select name="category_id" class="input">
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="label">Deskripsi</label>
    <textarea name="description" rows="3" class="input">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="label">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" min="0" required class="input">
    </div>
    <div>
        <label class="label">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required class="input">
    </div>
</div>

<div>
    <label class="label">Status</label>
    <select name="status" class="input">
        <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
        <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>

<div>
    <label class="label">Foto Produk</label>
    <input type="file" name="image" accept="image/*" class="input">
    @if (($product->image ?? null))
        <img src="{{ Storage::url($product->image) }}" class="mt-2 h-20 w-20 rounded-lg object-cover">
    @endif
</div>
