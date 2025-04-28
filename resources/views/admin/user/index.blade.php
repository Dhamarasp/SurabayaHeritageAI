@extends('admin.app')

@section('title', 'Users')

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
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Users</h1>
        <p class="text-gray-600">Manage user accounts</p>
    </div>
    <a href="{{ route('user.create') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add New User
    </a>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6 fade-in" x-intersect="$el.classList.add('appear')">
    <form action="{{ route('user.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-4">
        <div class="w-full md:w-1/3">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search users..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
            </div>
        </div>
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <div>
                <label for="role" class="sr-only">Role</label>
                <select id="role" name="role" class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort" class="sr-only">Sort</label>
                <select id="sort" name="sort" class="px-4 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                    Filter
                </button>
                <a href="{{ route('user.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-300">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden fade-in" x-intersect="$el.classList.add('appear')">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">User</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Joined</th>
                    <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role_id == 1 ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ $user->role->name ?? 'Unknown' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $user->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('user.show', $user->id) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('user.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
