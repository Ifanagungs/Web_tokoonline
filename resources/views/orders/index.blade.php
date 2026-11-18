@extends('layouts.storefront')

@section('title', 'Pesanan Saya - Toko Tri Bhakti At Taqwa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium">Pesanan Saya</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h1>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('orders.show', $order) }}"
                        class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-emerald-200 transition-all group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">{{ $order->order_number }}</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }} •
                                    {{ $order->payment_method_label }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-lg font-extrabold text-emerald-600">{{ $order->formatted_total }}</span>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">Belum ada pesanan</p>
                <p class="text-gray-400 text-sm mt-1">Mulai belanja dan buat pesanan pertama Anda!</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection