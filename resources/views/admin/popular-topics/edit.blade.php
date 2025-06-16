@extends('layouts.admin', [
    'title' => 'Edit Topik Populer',
    'subtitle' => 'Perbarui topik populer yang ditampilkan di halaman chat'
])

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Topik Populer: {{ $popularTopic->display_text }}</h2>

        <form method="POST" action="{{ route('admin.popular-topics.update', $popularTopic) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="display_text" class="block text-sm font-medium text-gray-700 mb-1">Teks Tampilan</label>
                <input type="text" name="display_text" id="display_text" value="{{ old('display_text', $popularTopic->display_text) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('display_text') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Teks yang akan ditampilkan di tombol topik populer</p>
                @error('display_text')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                <input type="text" name="question" id="question" value="{{ old('question', $popularTopic->question) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('question') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Pertanyaan yang akan dikirim ke chatbot saat tombol diklik</p>
                @error('question')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="order" id="order" value="{{ old('order', $popularTopic->order) }}" required min="1"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('order') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Urutan tampilan (angka yang lebih kecil akan ditampilkan lebih dulu)</p>
                @error('order')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $popularTopic->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktif
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-1">Topik populer yang aktif akan ditampilkan di halaman chat</p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.popular-topics.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300 mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
