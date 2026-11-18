@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
    {{-- Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <p class="text-sm text-gray-500">Total {{ $orders->total() }} pesanan</p>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan..."
                class="rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200 w-48">
            <select name="status"
                class="rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                <option value="">Semua Status</option>
                <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu
                    Pembayaran</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors">Filter</button>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">No. Pesanan</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">Pelanggan</th>
                        <th class="text-right px-5 py-3 font-semibold text-gray-700">Total</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Pembayaran</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Status</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Tanggal</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="font-semibold text-emerald-600 hover:text-emerald-700">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $order->recipient_name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->name ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3 text-right font-bold text-gray-800">{{ $order->formatted_total }}</td>
                            <td class="px-5 py-3 text-center">
                                <p class="text-xs text-gray-600 mb-1">{{ $order->payment_method_label }}</p>
                                @if($order->payment_method === 'transfer_bank')
                                    @if($order->payment_receipt)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                            ADA BUKTI
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-400">
                                            BELUM ADA
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="px-5 py-3 text-center text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors inline-block"
                                    title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
@endsection