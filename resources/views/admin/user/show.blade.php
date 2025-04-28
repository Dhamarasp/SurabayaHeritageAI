@extends('admin.app')

@section('title', 'User Details')

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
</style>
@endsection

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">User Details</h1>
            <p class="text-gray-600">View user information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('user.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Users
            </a>
            <a href="{{ route('user.edit', $user->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit User
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Profile -->
    <div class="bg-white rounded-lg shadow-md p-6 fade-in" x-intersect="$el.classList.add('appear')">
        <div class="flex flex-col items-center text-center">
            <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                <span class="text-gray-600 text-3xl font-medium">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->email }}</p>
            <div class="mt-2">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $user->role_id == 1 ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                    {{ $user->role->name ?? 'Unknown' }}
                </span>
            </div>
        </div>
        
        <div class="mt-6 border-t border-gray-200 pt-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-500">Member since</span>
                <span class="text-gray-800">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-500">Last updated</span>
                <span class="text-gray-800">{{ $user->updated_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">User ID</span>
                <span class="text-gray-800">{{ $user->id }}</span>
            </div>
        </div>
    </div>
    
    <!-- User Bio -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 h-full fade-in" x-intersect="$el.classList.add('appear')">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Bio</h2>
            <div class="prose max-w-none">
                @if($user->bio)
                    <p class="text-gray-700">{{ $user->bio }}</p>
                @else
                    <p class="text-gray-500 italic">No bio information available.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- User Activity -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow-md p-6 fade-in" x-intersect="$el.classList.add('appear')">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
            
            <!-- This is a placeholder for user activity. In a real application, you would fetch and display actual user activity data -->
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-gray-500">No recent activity to display.</p>
            </div>
        </div>
    </div>
</div>
@endsection
