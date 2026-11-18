@extends('layouts.storefront')

@section('title', 'Checkout - Toko Tri Bhakti At Taqwa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('cart.index') }}" class="hover:text-emerald-600">Keranjang</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium">Checkout</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Shipping Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Recipient Details --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Data Pengiriman
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="recipient_name" value="{{ old('recipient_name', $user->name) }}"
                                    required
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                                    placeholder="Nama lengkap penerima">
                                @error('recipient_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="recipient_phone" value="{{ old('recipient_phone', $user->phone) }}"
                                    required
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                                    placeholder="08xx-xxxx-xxxx">
                                @error('recipient_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman <span
                                        class="text-red-500">*</span></label>
                                <textarea name="shipping_address" rows="3" required
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                                    placeholder="Alamat lengkap (nama jalan, RT/RW, kelurahan, kecamatan, kota, kode pos)">{{ old('shipping_address', $user->address) }}</textarea>
                                @error('shipping_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                <textarea name="notes" rows="2"
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                                    placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6"
                        x-data="{ method: '{{ old('payment_method', 'transfer_bank') }}' }">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Metode Pembayaran
                        </h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all"
                                :class="method === 'transfer_bank' ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-gray-300'">
                                <input type="radio" name="payment_method" value="transfer_bank" x-model="method"
                                    class="text-emerald-600 focus:ring-emerald-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">Transfer Bank</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Pembayaran via transfer ke rekening toko</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all"
                                :class="method === 'cod' ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-gray-300'">
                                <input type="radio" name="payment_method" value="cod" x-model="method"
                                    class="text-emerald-600 focus:ring-emerald-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">COD (Bayar di Tempat)</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Bayar saat barang diterima</p>
                                </div>
                            </label>
                        </div>
                        @error('payment_method') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3 max-h-64 overflow-y-auto mb-4">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                        class="w-14 h-14 rounded-lg object-cover shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 line-clamp-1">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x
                                            {{ $item->product->formatted_price }}</p>
                                        <p class="text-sm font-semibold text-emerald-600">{{ $item->formatted_subtotal }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-3 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Ongkos Kirim</span>
                                <span class="font-semibold text-emerald-600">Rp
                                    {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-100 pt-2 flex justify-between">
                                <span class="font-bold text-gray-800">Total Bayar</span>
                                <span class="font-extrabold text-lg text-emerald-600">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-5 w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}"
                            class="mt-3 w-full py-2.5 border border-gray-200 text-gray-700 font-medium rounded-xl flex items-center justify-center text-sm hover:bg-gray-50 transition-all">
                            ← Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection