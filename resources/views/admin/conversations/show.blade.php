@extends('layouts.admin', [
    'title' => 'Detail Percakapan',
    'subtitle' => 'Lihat detail percakapan dan pesan-pesan di dalamnya'
])

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ $conversation->title ?? 'Percakapan Baru' }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.conversations.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">
                    Kembali
                </a>
                <form method="POST" action="{{ route('admin.conversations.destroy', $conversation) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus percakapan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Percakapan</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">ID Percakapan</p>
                            <p class="font-medium">{{ $conversation->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium">
                                <span class="px-2 py-1 text-xs font-semibold {{ $conversation->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full">
                                    {{ $conversation->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Dibuat Pada</p>
                            <p class="font-medium">{{ $conversation->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                            <p class="font-medium">{{ $conversation->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pengguna</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Pengguna</p>
                            <p class="font-medium">{{ $conversation->user->name ?? 'Anonim' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $conversation->user->email ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">ID Sesi</p>
                            <p class="font-medium text-xs break-all">{{ $conversation->session_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 bg-white border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pesan-pesan</h3>
        
        <div class="space-y-4 max-h-[600px] overflow-y-auto p-4 bg-gray-50 rounded-lg">
            @foreach($messages as $message)
                <div class="flex {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="{{ $message->role === 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }} rounded-lg p-4 max-w-[80%] shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="font-semibold">{{ $message->role === 'user' ? 'Pengguna' : 'AI' }}</span>
                            @if($message->role === 'ai' && $message->source)
                                <span class="ml-2 px-2 py-0.5 text-xs font-semibold {{ $message->source === 'local' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }} rounded-full">
                                    {{ $message->source }}
                                </span>
                            @endif
                            <span class="ml-auto text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
