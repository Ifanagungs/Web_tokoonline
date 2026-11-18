@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.orders.index') }}"
            class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:text-emerald-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">Review dan perbarui status pesanan {{ $order->order_number }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Order Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <span
                        class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                </div>

                {{-- Update Status --}}
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                    class="flex items-end gap-3 p-4 bg-gray-50 rounded-xl">
                    @csrf @method('PATCH')
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Ubah Status Pesanan</label>
                        <select name="status"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                            <option value="pending_payment" {{ $order->status == 'pending_payment' ? 'selected' : '' }}>
                                Menunggu Pembayaran</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Sedang Dikirim
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors">
                        Perbarui
                    </button>
                </form>
            </div>

            {{-- Items --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Produk Dipesan</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex gap-3 p-3 rounded-xl bg-gray-50">
                            @if($item->product)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}"
                                    class="w-14 h-14 rounded-lg object-cover shrink-0">
                            @else
                                <div
                                    class="w-14 h-14 rounded-lg bg-gray-200 shrink-0 flex items-center justify-center text-gray-400 text-xs">
                                    N/A</div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->quantity }} x {{ $item->formatted_price }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-800 self-center">{{ $item->formatted_subtotal }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span
                            class="font-semibold">{{ $order->formatted_subtotal }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Ongkos Kirim</span><span
                            class="font-semibold">{{ $order->formatted_shipping_cost }}</span></div>
                    <div class="flex justify-between border-t border-gray-100 pt-2"><span
                            class="font-bold text-gray-800">Total</span><span
                            class="font-extrabold text-emerald-600 text-lg">{{ $order->formatted_total }}</span></div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Info Pelanggan</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Nama Akun</span>
                        <span class="font-medium text-gray-800">{{ $order->user->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Email</span>
                        <span class="font-medium text-gray-800">{{ $order->user->email ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Info Pengiriman</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Penerima</span>
                        <span class="font-medium text-gray-800">{{ $order->recipient_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Telepon</span>
                        <span class="font-medium text-gray-800">{{ $order->recipient_phone }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Alamat</span>
                        <span class="font-medium text-gray-800">{{ $order->shipping_address }}</span>
                    </div>
                    @if($order->notes)
                        <div>
                            <span class="text-gray-500 block text-xs mb-0.5">Catatan</span>
                            <span class="font-medium text-gray-800">{{ $order->notes }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Info Pembayaran</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Metode</span>
                        <span class="font-medium text-gray-800">{{ $order->payment_method_label }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs mb-0.5">Total</span>
                        <span class="font-extrabold text-emerald-600 text-lg">{{ $order->formatted_total }}</span>
                    </div>
                </div>

                @if($order->payment_receipt)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-gray-500 block text-xs mb-2">Bukti Pembayaran</span>
                        <a href="{{ $order->payment_receipt_url }}" target="_blank" class="inline-block relative group">
                            <img src="{{ $order->payment_receipt_url }}" alt="Bukti Pembayaran"
                                class="w-24 h-32 object-cover rounded-lg shadow-sm border border-gray-200">
                            <div
                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection