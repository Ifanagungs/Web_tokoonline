@extends('admin.layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-500">Total {{ $categories->total() }} kategori</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kategori..."
                    class="rounded-xl border-gray-200 text-sm focus:border-emerald-400 focus:ring-emerald-200 w-48">
                {{-- <button type="submit"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors">Filter</button>
                --}}
            </form>
            <a href="{{ route('admin.categories.create') }}"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl flex items-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Categories Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">Kategori</th>
                        <th class="text-left px-5 py-3 font-semibold text-gray-700">Slug</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Total Produk</th>
                        <th class="text-center px-5 py-3 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 text-lg">
                                        {{ $category->icon ?? '📁' }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $category->slug }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold {{ $category->products_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $category->products_count }} Produk
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
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
                            <td colspan="4" class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Belum ada kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection