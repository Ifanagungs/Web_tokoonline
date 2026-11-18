{{-- Storefront Footer --}}
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-lg object-cover">
                    <div>
                        <h3 class="text-lg font-bold text-white">Tri Bhakti At Taqwa</h3>
                        <p class="text-xs text-gray-500">Toko Online</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">Toko online terpercaya menyediakan berbagai koleksi
                    baju dan buku berkualitas dengan harga terjangkau.</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}"
                            class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">Katalog Produk</a>
                    </li>
                    @auth
                        <li><a href="{{ route('cart.index') }}"
                                class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">Keranjang</a></li>
                        <li><a href="{{ route('orders.index') }}"
                                class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">Pesanan Saya</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        info@tribhaktiattaqwa.com
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        +62 822-7880-2062
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Jl.Simpang Rantai No 6 Rama Puja Raman Utara Lampung Timur
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Toko Tri Bhakti At Taqwa. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>