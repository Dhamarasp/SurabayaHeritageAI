@extends('layouts.admin', [
    'title' => 'Tambah Kata Kunci',
    'subtitle' => 'Tambahkan kata kunci baru untuk filter pertanyaan'
])

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Kata Kunci Baru</h2>

        <form method="POST" action="{{ route('admin.keywords.store') }}">
            @csrf

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                <select name="type" id="type" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('type') border-red-500 @enderror">
                    <option value="">Pilih Tipe</option>
                    <option value="surabaya" {{ old('type') == 'surabaya' ? 'selected' : '' }}>Surabaya</option>
                    <option value="history" {{ old('type') == 'history' ? 'selected' : '' }}>Sejarah</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Tipe kata kunci menentukan kategori filter</p>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="word" class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
                <input type="text" name="word" id="word" value="{{ old('word') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('word') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Contoh: surabaya, sejarah, perang, dll.</p>
                @error('word')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktif
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-1">Kata kunci yang aktif akan digunakan dalam filter pertanyaan</p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.keywords.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300 mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
