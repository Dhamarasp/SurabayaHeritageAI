@extends('layouts.admin', [
    'title' => 'Statistik Percakapan',
    'subtitle' => 'Analisis data percakapan pengguna dengan SurabayaAI'
])

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Conversation by Date Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Percakapan per Hari (30 Hari Terakhir)</h3>
        <div class="h-80">
            <canvas id="conversationsByDateChart"></canvas>
        </div>
    </div>

    <!-- Message Sources Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Sumber Jawaban AI</h3>
        <div class="h-80">
            <canvas id="messageSourcesChart"></canvas>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="p-6 bg-white border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengguna Paling Aktif</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Percakapan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topUsersByConversations as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->user->name ?? 'Pengguna Dihapus' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $item->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->count }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold text-gray-700">Ringkasan Data</h3>
    <a href="{{ route('admin.conversations.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">
        Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Message Source Summary -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Sumber Jawaban</h4>
        <div class="space-y-4">
            @foreach($messagesBySource as $source)
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $source->source ?? 'Tidak diketahui' }}</span>
                    <span class="text-sm text-gray-500">{{ $source->count }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($source->count / $messagesBySource->sum('count')) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Conversation by Date Summary -->
    <div class="bg-white rounded-lg shadow-md p-6 col-span-2">
        <h4 class="font-semibold text-gray-700 mb-4">Percakapan per Hari (7 Hari Terakhir)</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Percakapan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($conversationsByDate->take(7) as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->count }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Conversations by Date Chart
    const conversationsByDateCtx = document.getElementById('conversationsByDateChart').getContext('2d');
    const conversationsByDateChart = new Chart(conversationsByDateCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($conversationsByDate as $item)
                '{{ \Carbon\Carbon::parse($item->date)->format('d M') }}',
                @endforeach
            ],
            datasets: [{
                label: 'Jumlah Percakapan',
                data: [
                    @foreach($conversationsByDate as $item)
                    {{ $item->count }},
                    @endforeach
                ],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Message Sources Chart
    const messageSourcesCtx = document.getElementById('messageSourcesChart').getContext('2d');
    const messageSourcesChart = new Chart(messageSourcesCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($messagesBySource as $source)
                '{{ $source->source ?? "Tidak diketahui" }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($messagesBySource as $source)
                    {{ $source->count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#ef4444',
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#8b5cf6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection
