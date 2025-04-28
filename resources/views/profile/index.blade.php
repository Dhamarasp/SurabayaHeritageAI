@extends('app')
@section('title', 'Profile')

@section('style')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    
    /* Animation Classes */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .fade-in.appear {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="min-h-screen" x-data="profileApp()"
    x-init="
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
         ">
        
        <main class="flex-1 pt-24 pb-12 px-4">
            <div class="container mx-auto max-w-4xl">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800">User Profile</h1>
                        <p class="text-gray-600">Manage your account information</p>
                    </div>
    
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <!-- Profile Navigation -->
                            <div class="w-full md:w-1/4 mb-6 md:mb-0">
                                <nav class="space-y-1">
                                    <button 
                                        @click="activeTab = 'profile'" 
                                        :class="activeTab === 'profile' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Personal Information
                                    </button>
                                    <button 
                                        @click="activeTab = 'security'" 
                                        :class="activeTab === 'security' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Security
                                    </button>
                                    <button 
                                        @click="activeTab = 'preferences'" 
                                        :class="activeTab === 'preferences' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Preferences
                                    </button>
                                    <button 
                                        @click="activeTab = 'danger'" 
                                        :class="activeTab === 'danger' ? 'bg-red-50 text-red-700' : 'text-red-600 hover:bg-red-50 hover:text-red-700'"
                                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Danger Zone
                                    </button>
                                </nav>
                            </div>
    
                            <!-- Profile Content -->
                            <div class="w-full md:w-3/4 md:pl-8">
                                <!-- Personal Information Tab -->
                                <div x-show="activeTab === 'profile'" class="space-y-6">
                                    <h2 class="text-xl font-semibold text-gray-800">Personal Information</h2>
                                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                            <input type="text" id="name" name="name" value="{{ $user->name ?? old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" id="email" name="email" value="{{ $user->email ?? old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                            <textarea id="bio" name="bio" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">{{ $user->bio ?? old('bio') }}</textarea>
                                            @error('bio')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
    
                                <!-- Security Tab -->
                                <div x-show="activeTab === 'security'" class="space-y-6">
                                    <h2 class="text-xl font-semibold text-gray-800">Security</h2>
                                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                            <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                            @error('current_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                            <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                            @error('new_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                        </div>
                                        <div>
                                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
    
                                <!-- Preferences Tab -->
                                <div x-show="activeTab === 'preferences'" class="space-y-6">
                                    <h2 class="text-xl font-semibold text-gray-800">Preferences</h2>
                                    <form action="{{ route('profile.preferences') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="email_notifications" checked class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                                                <span class="ml-2 text-gray-700">Receive email notifications</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="save_history" checked class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                                                <span class="ml-2 text-gray-700">Save chat history</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                            <select name="language" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                                <option value="id" selected>Bahasa Indonesia</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                                Save Preferences
                                            </button>
                                        </div>
                                    </form>
                                </div>
    
                                <!-- Danger Zone Tab -->
                                <div x-show="activeTab === 'danger'" class="space-y-6">
                                    <h2 class="text-xl font-semibold text-red-600">Danger Zone</h2>
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-red-800 mb-2">Delete Account</h3>
                                        <p class="text-red-600 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                        <button 
                                            @click="showDeleteAccountModal = true" 
                                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                            Delete Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    
        <!-- Delete Account Confirmation Modal -->
        <div 
            x-show="showDeleteAccountModal" 
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div 
                class="bg-white rounded-lg shadow-xl p-6 max-w-md mx-4 w-full"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Delete Account</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete your account? All of your data will be permanently removed. This action cannot be undone.</p>
                
                <form action="{{ route('profile.delete') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button 
                            type="button"
                            @click="showDeleteAccountModal = false" 
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition duration-200">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileApp', () => ({
            mobileMenuOpen: false,
            activeTab: 'profile',
            showDeleteAccountModal: false
        }));
    });
</script>
@endsection

