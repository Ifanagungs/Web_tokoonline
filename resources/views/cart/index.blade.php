@extends('layouts.storefront')

@section('title', 'Keranjang Belanja - Toko Tri Bhakti At Taqwa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="cartManager()">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium">Keranjang Belanja</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="cart-container">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 flex gap-4 fade-in"
                            id="cart-item-{{ $item->id }}">
                            {{-- Product Image --}}
                            <a href="{{ route('products.show', $item->product->slug) }}" class="shrink-0">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                    class="w-24 h-24 sm:w-28 sm:h-28 object-cover rounded-xl">
                            </a>

                            {{-- Product Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <a href="{{ route('products.show', $item->product->slug) }}"
                                            class="text-sm sm:text-base font-semibold text-gray-800 hover:text-emerald-600 transition-colors line-clamp-2">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $item->product->category->name ?? '' }}</p>
                                    </div>
                                    {{-- Delete Button --}}
                                    <button onclick="removeFromCart({{ $item->id }})"
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all shrink-0"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <p class="text-emerald-600 font-bold mt-2">{{ $item->product->formatted_price }}</p>

                                {{-- Quantity Controls --}}
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="w-10 text-center text-sm font-semibold"
                                            id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all {{ $item->quantity >= $item->product->stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="text-sm font-bold text-gray-800"
                                        id="subtotal-{{ $item->id }}">{{ $item->formatted_subtotal }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Belanja</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                                <span class="font-semibold" id="cart-subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Ongkos Kirim</span>
                                <span class="font-semibold text-emerald-600">Rp
                                    {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-100 pt-3 flex justify-between">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-extrabold text-lg text-emerald-600" id="cart-total">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                            class="mt-5 w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                            {{-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg> --}}
                            Lanjut ke Checkout
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="mt-3 w-full py-2.5 border border-gray-200 text-gray-700 font-medium rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50 transition-all text-sm">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">Keranjang belanja kosong</p>
                <p class="text-gray-400 text-sm mt-1">Yuk, mulai belanja sekarang!</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function cartManager() {
            return {
                loading: false,
            };
        }

        function updateQuantity(cartId, newQty) {
            if (newQty < 1) return;
            fetch(`/cart/${cartId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: newQty })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.itemSubtotal) {
                        document.getElementById('subtotal-' + cartId).textContent = data.itemSubtotal;
                        document.getElementById('cart-subtotal').textContent = data.cartSubtotal;
                        document.getElementById('cart-total').textContent = data.cartTotal;
                    }
                    // Reload to update button states
                    location.reload();
                })
                .catch(() => showToast('Gagal memperbarui jumlah', 'error'));
        }

        function removeFromCart(cartId) {
            if (!confirm('Hapus produk ini dari keranjang?')) return;
            fetch(`/cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
                .then(r => r.json())
                .then(data => {
                    if (data.isEmpty) {
                        location.reload();
                    } else {
                        document.getElementById('cart-item-' + cartId).remove();
                        document.getElementById('cart-subtotal').textContent = data.cartSubtotal;
                        document.getElementById('cart-total').textContent = data.cartTotal;
                    }
                    showToast(data.message, 'success');
                })
                .catch(() => showToast('Gagal menghapus produk', 'error'));
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white text-sm font-medium ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
            toast.textContent = (type === 'success' ? '✓ ' : '✕ ') + message;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>
@endpush