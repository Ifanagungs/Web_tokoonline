@extends('layouts.storefront')

@section('title', 'Toko Tri Bhakti At Taqwa - Belanja Baju & Buku Online')

@section('content')
    {{-- Hero Section --}}
    <section class="gradient-hero text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 relative z-10">
            <div class="max-w-2xl">
                <div
                    class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white/90 text-sm px-4 py-1.5 rounded-full mb-6">
                    <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                    Selamat datang di Toko Tri Bhakti At Taqwa
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold leading-tight mb-4">
                    Belanja <span class="text-emerald-300">Baju</span> & <span class="text-emerald-300">Buku</span>
                    <br>Berkualitas Terbaik
                </h1>
                <p class="text-lg text-emerald-100/80 mb-8 leading-relaxed">
                    Temukan koleksi baju pilihan dan buku-buku terbaru dengan harga terjangkau. Belanja mudah, aman, dan
                    cepat di Toko Tri Bhakti At Taqwa.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-emerald-700 font-bold rounded-xl hover:bg-emerald-50 transition-all shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Mulai Belanja
                    </a>
                    <a href="{{ route('products.index', ['category' => '']) }}"
                        class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/20 transition-all border border-white/20">
                        Lihat Katalog
                    </a>
                </div>
            </div>
        </div>
        {{-- Decorative circles --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-20 w-60 h-60 bg-emerald-300/10 rounded-full blur-3xl"></div>
    </section>

    {{-- Categories Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="grid grid-cols-2 sm:grid-cols-{{ count($categories) > 2 ? count($categories) : 2 }} gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                    class="glass-card rounded-2xl p-5 flex items-center gap-4 shadow-lg hover:shadow-xl transition-all group hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        {{ $category->icon ?? '📦' }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">{{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $category->products_count }} produk</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Produk Terbaru</h2>
                <p class="text-gray-500 mt-1">Koleksi terbaru untuk Anda</p>
            </div>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-semibold text-sm transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    @include('components.storefront.product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500 text-lg">Belum ada produk tersedia.</p>
                <p class="text-gray-400 text-sm mt-1">Produk akan segera hadir!</p>
            </div>
        @endif
    </section>

    {{-- CTA Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="gradient-primary rounded-3xl p-8 sm:p-12 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white rounded-full"></div>
                <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white rounded-full"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-2xl sm:text-3xl font-bold mb-3">Siap Berbelanja?</h2>
                <p class="text-emerald-100 mb-6 max-w-lg mx-auto">Daftar sekarang dan nikmati pengalaman belanja online yang
                    mudah dan menyenangkan.</p>
                @guest
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-emerald-700 font-bold rounded-xl hover:bg-emerald-50 transition-all shadow-lg">
                        Daftar Gratis
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endguest
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function addToCart(productId) {
            fetch('{{ route("cart.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.cartCount !== undefined) {
                        // Update all Alpine cart count instances
                        document.querySelectorAll('[x-data]').forEach(el => {
                            if (el.__x && el.__x.$data.cartCount !== undefined) {
                                el.__x.$data.cartCount = data.cartCount;
                            }
                            // Alpine v3
                            if (el._x_dataStack) {
                                el._x_dataStack.forEach(d => {
                                    if (d.cartCount !== undefined) d.cartCount = data.cartCount;
                                });
                            }
                        });
                    }
                    showToast(data.message, 'success');
                })
                .catch(() => showToast('Gagal menambahkan ke keranjang', 'error'));
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white text-sm font-medium flex items-center gap-2 transform transition-all duration-300 ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
            toast.innerHTML = `${type === 'success' ? '✓' : '✕'} ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>
@endpush