@extends('layouts.storefront')

@section('title', 'Katalog Produk - Toko Tri Bhakti At Taqwa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium">Katalog Produk</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Filter Sidebar --}}
            <aside x-data="{ showFilter: false }" class="lg:w-72 shrink-0">
                {{-- Mobile Filter Toggle --}}
                <button @click="showFilter = !showFilter"
                    class="lg:hidden w-full flex items-center justify-between bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
                    <span class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter Produk
                    </span>
                    <svg class="w-5 h-5 transition-transform" :class="showFilter ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <form action="{{ route('products.index') }}" method="GET" :class="showFilter ? 'block' : 'hidden'"
                    class="lg:block">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-6">
                        {{-- Category Filter --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Kategori
                            </h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                                        class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-sm text-gray-600 group-hover:text-emerald-600 transition-colors">Semua
                                        Kategori</span>
                                </label>
                                @foreach($categories as $category)
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }}
                                            class="text-emerald-600 focus:ring-emerald-500">
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-emerald-600 transition-colors">{{ $category->icon }}
                                            {{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Rentang Harga
                            </h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs text-gray-500 mb-1 block">Min (Rp)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                                        class="w-full rounded-lg border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 mb-1 block">Max (Rp)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                                        placeholder="999999"
                                        class="w-full rounded-lg border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                                </div>
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 mb-3">Urutkan</h3>
                            <select name="sort"
                                class="w-full rounded-lg border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors">
                            Terapkan Filter
                        </button>

                        @if(request()->hasAny(['category', 'min_price', 'max_price', 'sort', 'search']))
                            <a href="{{ route('products.index') }}"
                                class="block text-center text-sm text-gray-500 hover:text-red-500 transition-colors">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </aside>

            {{-- Products Grid --}}
            <div class="flex-1">
                {{-- Search Info --}}
                @if(request('search'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-6 flex items-center justify-between">
                        <p class="text-sm text-emerald-800">
                            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                            <span class="text-emerald-600">({{ $products->total() }} produk ditemukan)</span>
                        </p>
                        <a href="{{ route('products.index') }}"
                            class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">Hapus</a>
                    </div>
                @endif

                {{-- Products Count & Current Filter --}}
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-500">Menampilkan <strong
                            class="text-gray-800">{{ $products->total() }}</strong> produk</p>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            @include('components.storefront.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Produk tidak ditemukan</p>
                        <p class="text-gray-400 text-sm mt-1">Coba ubah kata kunci pencarian atau filter Anda</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-colors">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
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

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white text-sm font-medium ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
            toast.textContent = (type === 'success' ? '✓ ' : '✕ ') + message;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>
@endpush