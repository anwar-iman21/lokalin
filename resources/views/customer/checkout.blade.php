<x-layouts.app title="Checkout">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Checkout</h1>

    <form method="POST" action="{{ route('customer.checkout.store') }}" x-data="{ method: '{{ old('fulfillment_method', 'delivery') }}' }">
        @csrf
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="card">
                    <h2 class="font-semibold text-gray-800 mb-4">Metode Pengambilan</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 p-3 text-sm has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                            <input type="radio" name="fulfillment_method" value="delivery" x-model="method" class="text-primary-600">
                            🛵 Diantar (Delivery)
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 p-3 text-sm has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                            <input type="radio" name="fulfillment_method" value="pickup" x-model="method" class="text-primary-600">
                            🏪 Ambil Sendiri (Pickup)
                        </label>
                    </div>
                </div>

                <div class="card">
                    <h2 class="font-semibold text-gray-800 mb-4">Data Penerima</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="label">Nama Penerima</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" required class="input">
                        </div>
                        <div>
                            <label class="label">Nomor HP</label>
                            <input type="text" name="recipient_phone" value="{{ old('recipient_phone', auth()->user()->phone) }}" required class="input">
                        </div>

                        <div x-show="method === 'delivery'" x-cloak>
                            <label class="label">Alamat Pengantaran</label>
                            <textarea name="address" rows="2" class="input">{{ old('address') }}</textarea>

                            <div class="mt-3 flex items-center gap-3">
                                <button type="button" class="btn-secondary !py-2 !text-xs" onclick="lokalinGetLocation('latitude', 'longitude', 'geo-status')">📍 Gunakan Lokasi Saya (GPS)</button>
                                <span id="geo-status" class="text-xs text-gray-500"></span>
                            </div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>

                        <div>
                            <label class="label">Catatan (opsional)</label>
                            <textarea name="delivery_note" rows="2" class="input">{{ old('delivery_note') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card" x-show="method === 'pickup'" x-cloak>
                    <h2 class="font-semibold text-gray-800 mb-2">Info Pengambilan</h2>
                    <p class="text-sm text-gray-500">📍 {{ $cart->umkm->address }}</p>
                    <p class="text-sm text-gray-500">🕐 {{ $cart->umkm->opening_hours }}</p>
                </div>
            </div>

            <div class="card h-fit">
                <h2 class="font-semibold text-gray-800">Ringkasan Pesanan</h2>
                <div class="mt-4 space-y-2 text-sm">
                    @foreach ($cart->items as $item)
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span class="font-medium">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 border-t pt-4 flex justify-between font-semibold">
                    <span>Total</span>
                    <span class="text-primary-600">Rp {{ number_format($cart->subtotal(), 0, ',', '.') }}</span>
                </div>
                <button type="submit" class="btn-primary mt-6 w-full">Buat Pesanan</button>
            </div>
        </div>
    </form>
</x-layouts.app>
