@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}"
            class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:text-emerald-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Buat kategori baru untuk mengelompokkan produk Anda</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">Nama Kategori <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Misal: Pakaian Pria">
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Icon --}}
                <div>
                    <label for="icon" class="block text-sm font-semibold text-gray-800 mb-2">Ikon (Emoji) <span
                            class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                        class="w-24 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-2xl text-center"
                        placeholder="👕" maxlength="10">
                    <p class="text-xs text-gray-500 mt-2">Gunakan Emoji (contoh: 👕, 📚, 🍵) untuk mempercantik tampilan.
                    </p>
                    @error('icon') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 shadow-sm transition-colors">Simpan
                    Kategori</button>
            </div>
        </form>
    </div>
@endsection