@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ $totalProducts }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pesanan</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pesanan Baru</p>
                    <p class="text-2xl font-extrabold text-orange-600 mt-1">{{ $pendingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-xl font-extrabold text-emerald-600 mt-1">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua</a>
            </div>
            @if($recentOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 group-hover:text-emerald-600">
                                    {{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->name ?? 'User' }} •
                                    {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-emerald-600">{{ $order->formatted_total }}</p>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full {{ $order->status_color }}">{{ $order->status_label }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-8">Belum ada pesanan</p>
            @endif
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    Stok Menipis
                </h3>
                <a href="{{ route('admin.products.index') }}"
                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Kelola</a>
            </div>
            @if($lowStockProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-10 h-10 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 line-clamp-1 group-hover:text-emerald-600">
                                    {{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->formatted_price }}</p>
                            </div>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-bold {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $product->stock <= 0 ? 'Habis' : "Sisa {$product->stock}" }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-8">Semua stok aman</p>
            @endif
        </div>
    </div>
@endsection