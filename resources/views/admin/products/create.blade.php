@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Kelola Produk')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}"
            class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:text-emerald-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan produk baru ke dalam katalog toko Anda</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                            placeholder="Contoh: Kaos Polos Hitam">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="100"
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                            placeholder="50000">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                            placeholder="100">
                        @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full rounded-xl border-gray-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-200 text-sm"
                            placeholder="Deskripsi lengkap produk...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-gray-700">Aktifkan produk (tampilkan di katalog)</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                        Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection