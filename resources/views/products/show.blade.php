@extends('layouts.storefront')

@section('title', $product->name . ' - Toko Tri Bhakti At Taqwa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('products.index') }}" class="hover:text-emerald-600 transition-colors">Katalog</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium line-clamp-1">{{ $product->name }}</span>
        </nav>

        {{-- Product Detail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                {{-- Image --}}
                <div class="relative bg-gray-50 aspect-square lg:aspect-auto lg:min-h-[500px]">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @if($product->stock <= 0)
                        <div class="absolute top-4 left-4">
                            <span class="bg-red-500 text-white text-sm font-bold px-4 py-1.5 rounded-full">Stok Habis</span>
                        </div>
                    @elseif($product->stock <= 5)
                        <div class="absolute top-4 left-4">
                            <span class="bg-orange-500 text-white text-sm font-bold px-4 py-1.5 rounded-full">Sisa
                                {{ $product->stock }} item</span>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-6 sm:p-8 lg:p-10 flex flex-col justify-between" x-data="{ quantity: 1 }">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <a href="{{ route('products.index', ['category' => $product->category_id]) }}"
                                class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full hover:bg-emerald-100 transition-colors">
                                {{ $product->category->icon ?? '📦' }} {{ $product->category->name }}
                            </a>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-3xl font-extrabold text-emerald-600">{{ $product->formatted_price }}</span>
                        </div>

                        @if($product->description)
                            <div class="mb-6">
                                <h3 class="text-sm font-bold text-gray-800 mb-2">Deskripsi Produk</h3>
                                <div class="text-sm text-gray-600 leading-relaxed prose prose-sm max-w-none">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-6 mb-6 py-4 border-t border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 {{ $product->stock > 0 ? 'text-emerald-500' : 'text-red-500' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span
                                    class="text-sm {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-600' }} font-medium">
                                    Stok: {{ $product->stock > 0 ? $product->stock . ' tersisa' : 'Habis' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="text-sm text-gray-600">Produk Original</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        @if($product->stock > 0)
                            <div class="space-y-4">
                                {{-- Quantity Selector --}}
                                <div>
                                    <label class="text-sm font-bold text-gray-800 mb-2 block">Jumlah</label>
                                    <div class="flex items-center gap-3">
                                        <button @click="quantity > 1 ? quantity-- : null"
                                            class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" x-model.number="quantity" min="1" max="{{ $product->stock }}"
                                            class="w-20 text-center rounded-xl border-gray-200 text-sm font-semibold focus:border-emerald-400 focus:ring-emerald-200">
                                        <button @click="quantity < {{ $product->stock }} ? quantity++ : null"
                                            class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                        <span class="text-xs text-gray-400">Maks. {{ $product->stock }}</span>
                                    </div>
                                </div>

                                {{-- Add to Cart Button --}}
                                <button @click="addToCartDetail({{ $product->id }}, quantity)"
                                    class="btn-cart w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all text-base">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        @else
                            <button disabled
                                class="w-full py-3.5 bg-gray-200 text-gray-500 font-bold rounded-xl cursor-not-allowed">Stok
                                Habis</button>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg transition-all">
                            Masuk untuk Belanja
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
            <section class="mt-12">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Produk Serupa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        @include('components.storefront.product-card', ['product' => $related])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function addToCartDetail(productId, quantity) {
            fetch('{{ route("cart.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
                .then(r => r.json())
                .then(data => {
                    document.querySelectorAll('[x-data]').forEach(el => {
                        if (el._x_dataStack) {
                            el._x_dataStack.forEach(d => {
                                if (d.cartCount !== undefined) d.cartCount = data.cartCount;
                            });
                        }
                    });
                    showToast(data.message, 'success');
                })
                .catch(() => showToast('Gagal menambahkan ke keranjang', 'error'));
        }
        function addToCart(productId) { addToCartDetail(productId, 1); }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white text-sm font-medium ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
            toast.textContent = (type === 'success' ? '✓ ' : '✕ ') + message;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>
@endpush