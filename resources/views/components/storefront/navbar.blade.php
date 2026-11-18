{{-- Storefront Navbar --}}
<nav x-data="{ open: false, cartCount: {{ auth()->check() ? auth()->user()->carts()->sum('quantity') : 0 }} }"
    class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-lg object-cover">
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-emerald-700 leading-tight">Tri Bhakti At Taqwa</h1>
                    <p class="text-xs text-gray-400 -mt-0.5">Toko Online</p>
                </div>
            </a>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari produk baju, buku..."
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all text-sm">
                    <svg class="absolute left-3.5 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-2 sm:gap-4">
                {{-- Products Link --}}
                <a href="{{ route('products.index') }}"
                    class="hidden sm:inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors rounded-lg hover:bg-emerald-50">
                    Katalog
                </a>

                @auth
                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative p-2 text-gray-600 hover:text-emerald-600 transition-colors rounded-lg hover:bg-emerald-50"
                        id="cart-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        <span x-show="cartCount > 0" x-text="cartCount"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center badge-bounce"
                            id="cart-badge"></span>
                    </a>

                    {{-- User Dropdown --}}
                    <div x-data="{ openDrop: false }" class="relative">
                        <button @click="openDrop = !openDrop"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-all">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="openDrop ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="openDrop" @click.away="openDrop = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Dashboard Admin
                                </a>
                            @endif
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Pesanan Saya
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-all shadow-sm hover:shadow-md">Daftar</a>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-3">
            <form action="{{ route('products.index') }}" method="GET">
                <input type="text" name="search" placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm">
            </form>
        </div>
        <div class="px-4 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">Beranda</a>
            <a href="{{ route('products.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">Katalog
                Produk</a>
            @auth
                <a href="{{ route('cart.index') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Keranjang</a>
                <a href="{{ route('orders.index') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Pesanan Saya</a>
            @endauth
        </div>
    </div>
</nav>