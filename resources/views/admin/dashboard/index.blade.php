@extends('admin.app')

@section('title', 'Dashboard')

@section('style')
<style>
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .fade-in.appear {
        opacity: 1;
        transform: translateY(0);
    }
    
    .stagger-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }
    
    .stagger-delay-1 { transition-delay: 0.1s; }
    .stagger-delay-2 { transition-delay: 0.2s; }
    .stagger-delay-3 { transition-delay: 0.3s; }
    .stagger-delay-4 { transition-delay: 0.4s; }
</style>
@endsection

@section('content')
<div class="mb-6" x-init="
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-gray-600">Welcome to the SurabayaAI admin panel.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6 stagger-item stagger-delay-1" 
         x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 100)">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Users</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 stagger-item stagger-delay-2" 
         x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 200)">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">New Users Today</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['new_users_today'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 stagger-item stagger-delay-3" 
         x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 300)">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Active Users</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['active_users'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 stagger-item stagger-delay-4" 
         x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 400)">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Conversations</p>
                <p class="text-2xl font-bold text-gray-800">0</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8 fade-in" x-intersect="$el.classList.add('appear')">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Users</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Joined</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($latest_users as $user)
                <tr>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $user->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="{{ route('user.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All Users →</a>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 fade-in" x-intersect="$el.classList.add('appear')">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-800">Add New User</p>
                <p class="text-sm text-gray-600">Create a new user account</p>
            </div>
        </a>
        <a href="#" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-800">Edit Content</p>
                <p class="text-sm text-gray-600">Update site content</p>
            </div>
        </a>
        <a href="#" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-800">View Reports</p>
                <p class="text-sm text-gray-600">Access analytics data</p>
            </div>
        </a>
    </div>
</div>
@endsection
