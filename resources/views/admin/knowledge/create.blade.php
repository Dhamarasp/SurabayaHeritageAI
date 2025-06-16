@extends('layouts.admin', [
    'title' => 'Tambah Entri Pengetahuan',
    'subtitle' => 'Tambahkan entri baru ke basis pengetahuan'
])

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Entri Pengetahuan Baru</h2>

        <form method="POST" action="{{ route('admin.knowledge.store') }}">
            @csrf

            <div class="mb-6">
                <label for="topic" class="block text-sm font-medium text-gray-700 mb-1">Topik</label>
                <input type="text" name="topic" id="topic" value="{{ old('topic') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('topic') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Contoh: battle of surabaya, bung tomo, surabaya name</p>
                @error('topic')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci (pisahkan dengan koma)</label>
                <input type="text" name="keywords" id="keywords" value="{{ old('keywords') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('keywords') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Contoh: pertempuran surabaya, 10 november, hari pahlawan</p>
                @error('keywords')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="response" class="block text-sm font-medium text-gray-700 mb-1">Respons</label>
                <textarea name="response" id="response" rows="10" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('response') border-red-500 @enderror">{{ old('response') }}</textarea>
                @error('response')
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
                <p class="text-xs text-gray-500 mt-1">Entri yang aktif akan digunakan dalam pencarian jawaban</p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.knowledge.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300 mr-2">
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
