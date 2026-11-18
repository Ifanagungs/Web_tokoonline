{{-- Product Card Component --}}
@props(['product'])

<div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group">
    {{-- Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden aspect-square">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
            class="w-full h-full object-cover transition-transform duration-500" loading="lazy">
        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Habis</span>
            </div>
        @elseif($product->stock <= 5)
            <div class="absolute top-3 left-3">
                <span class="bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">Sisa
                    {{ $product->stock }}</span>
            </div>
        @endif
        @if($product->category)
            <div class="absolute top-3 right-3">
                <span
                    class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-medium px-2 py-1 rounded-full">{{ $product->category->name }}</span>
            </div>
        @endif
    </a>

    {{-- Info --}}
    <div class="p-4">
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3
                class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-emerald-600 transition-colors mb-1">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-lg font-bold text-emerald-600 mb-3">{{ $product->formatted_price }}</p>

        @auth
            @if($product->stock > 0)
                <button onclick="addToCart({{ $product->id }})"
                    class="btn-cart w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    Tambah ke Keranjang
                </button>
            @else
                <button disabled
                    class="w-full py-2.5 bg-gray-200 text-gray-500 text-sm font-semibold rounded-xl cursor-not-allowed">Stok
                    Habis</button>
            @endif
        @else
            <a href="{{ route('login') }}"
                class="btn-cart w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
                Tambah ke Keranjang
            </a>
        @endauth
    </div>
</div>