@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-500">Total {{ $products->total() }} produk</p>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                    class="rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200 w-48">
                <select name="category"
                    class="rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors">Filter</button>
            </form>
            <a href="{{ route('admin.products.create') }}"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl flex items-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">Produk</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">Kategori</th>
                        <th class="text-right px-5 py-3 font-semibold text-gray-700">Harga</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Stok</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Status</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <p class="font-medium text-gray-800 line-clamp-1">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-400">{{ Str::limit($product->description, 40) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-right font-semibold text-gray-800">{{ $product->formatted_price }}</td>
                            <td class="px-5 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : ($product->stock <= 5 ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Belum ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection