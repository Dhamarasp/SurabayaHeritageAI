@extends('layouts.admin', [
    'title' => 'Manajemen Kata Kunci',
    'subtitle' => 'Kelola kata kunci untuk filter pertanyaan tentang sejarah Surabaya'
])

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('admin.keywords.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
        Tambah Kata Kunci
    </a>
</div>

<div class="p-6 bg-white rounded-lg shadow-md mb-6">
    @include('components.admin.search-form', [
        'action' => route('admin.keywords.index'),
        'placeholder' => 'Cari kata kunci...',
        'filters' => '
            <select name="type" class="ml-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Semua Tipe</option>
                <option value="surabaya" ' . (request('type') == 'surabaya' ? 'selected' : '') . '>Surabaya</option>
                <option value="history" ' . (request('type') == 'history' ? 'selected' : '') . '>Sejarah</option>
            </select>
            <select name="status" class="ml-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Semua Status</option>
                <option value="1" ' . (request('status') == '1' ? 'selected' : '') . '>Aktif</option>
                <option value="0" ' . (request('status') == '0' ? 'selected' : '') . '>Tidak Aktif</option>
            </select>
            <button type="submit" class="ml-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Filter
            </button>
        '
    ])
</div>

<!-- Surabaya Keywords -->
@if(!request('type') || request('type') == 'surabaya')
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kata Kunci Surabaya</h2>
        <p class="text-gray-600 mb-6">Kata kunci ini digunakan untuk mendeteksi apakah pertanyaan terkait dengan Surabaya.</p>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kata Kunci</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($surabayaKeywords as $keyword)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $keyword->word }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.keywords.toggle-status', $keyword) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 py-1 text-xs font-semibold {{ $keyword->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full hover:bg-opacity-80 transition duration-300">
                                    {{ $keyword->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->creator->name ?? 'Tidak diketahui' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->updated_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.keywords.edit', $keyword) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form method="POST" action="{{ route('admin.keywords.destroy', $keyword) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kata kunci ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-white border-t border-gray-200">
            {{ $surabayaKeywords->links() }}
        </div>
    </div>
</div>
@endif

<!-- History Keywords -->
@if(!request('type') || request('type') == 'history')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kata Kunci Sejarah</h2>
        <p class="text-gray-600 mb-6">Kata kunci ini digunakan untuk mendeteksi apakah pertanyaan terkait dengan sejarah.</p>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kata Kunci</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($historyKeywords as $keyword)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $keyword->word }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.keywords.toggle-status', $keyword) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 py-1 text-xs font-semibold {{ $keyword->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full hover:bg-opacity-80 transition duration-300">
                                    {{ $keyword->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->creator->name ?? 'Tidak diketahui' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $keyword->updated_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.keywords.edit', $keyword) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form method="POST" action="{{ route('admin.keywords.destroy', $keyword) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kata kunci ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-white border-t border-gray-200">
            {{ $historyKeywords->links() }}
        </div>
    </div>
</div>
@endif
@endsection
