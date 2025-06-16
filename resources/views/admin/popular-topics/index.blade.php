@extends('layouts.admin', [
    'title' => 'Manajemen Topik Populer',
    'subtitle' => 'Kelola topik populer yang ditampilkan di halaman chat'
])

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('admin.popular-topics.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
        Tambah Topik Populer
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Topik Populer</h2>
        <p class="text-gray-600 mb-6">Topik populer ini akan ditampilkan di halaman chat untuk memudahkan pengguna memilih topik yang ingin ditanyakan.</p>
        
        <div class="p-6">
            @include('components.admin.search-form', [
                'action' => route('admin.popular-topics.index'),
                'placeholder' => 'Cari topik populer...',
                'filters' => '
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
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teks Tampilan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-topics" class="bg-white divide-y divide-gray-200">
                    @foreach($topics as $topic)
                    <tr data-id="{{ $topic->id }}" class="cursor-move">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $topic->order }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $topic->display_text }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">{{ $topic->question }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.popular-topics.toggle-status', $topic) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 py-1 text-xs font-semibold {{ $topic->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full hover:bg-opacity-80 transition duration-300">
                                    {{ $topic->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $topic->creator->name ?? 'Tidak diketahui' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $topic->updated_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.popular-topics.edit', $topic) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form method="POST" action="{{ route('admin.popular-topics.destroy', $topic) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus topik populer ini?');">
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
            {{ $topics->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortableList = document.getElementById('sortable-topics');
        
        if (sortableList) {
            new Sortable(sortableList, {
                animation: 150,
                ghostClass: 'bg-gray-100',
                onEnd: function() {
                    // Get the new order
                    const rows = sortableList.querySelectorAll('tr');
                    const topicIds = Array.from(rows).map(row => row.dataset.id);
                    
                    // Send the new order to the server
                    fetch('{{ route('admin.popular-topics.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            topics: topicIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to show the new order
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }
    });
</script>
@endsection
