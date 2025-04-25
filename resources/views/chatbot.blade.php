<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SurabayaAI - Chat with History</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        
        /* Message Animation */
        .message-in {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }
        
        .message-in.appear {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Typing Animation */
        .typing-container {
            display: inline-block;
            max-width: 100%;
            overflow: hidden;
            white-space: normal;
        }

        .typing-text {
            display: inline;
            white-space: normal;
            word-wrap: break-word;
        }

        .typing-text span {
            opacity: 0;
            transition: opacity 0.05s ease;
        }

        .typing-text span.visible {
            opacity: 1;
        }

        .typing-cursor {
            display: inline-block;
            width: 2px;
            height: 1em;
            background-color: gray;
            margin-left: 1px;
            animation: blink-caret 0.75s step-end infinite;
        }

        @keyframes blink-caret {
            from, to { opacity: 0 }
            50% { opacity: 1 }
        }
        
        /* Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Shimmer Effect */
        .shimmer {
            background: linear-gradient(90deg, 
                rgba(255,255,255,0) 0%, 
                rgba(255,255,255,0.2) 50%, 
                rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
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
        
        /* Sidebar Transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Hover Effects */
        .conversation-item {
            transition: all 0.2s ease;
        }
        
        .conversation-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transform: translateX(5px);
        }
        
        .topic-item {
            transition: all 0.2s ease;
        }
        
        .topic-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col" 
      x-data="chatApp()">
    
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full z-50 bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <a href="/" class="text-2xl font-bold">SurabayaAI</a>
            </div>
    
            <!-- Mobile menu button -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar toggle for mobile -->
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                
                <!-- Hamburger for main menu -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="cursor-pointer md:hidden transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
    
            <!-- Desktop nav -->
            {{-- <nav class="hidden md:flex space-x-6">
                <a href="/" class="hover:text-gray-300 transition duration-300">Home</a>
                <a href="#" class="hover:text-gray-300 transition duration-300 border-b-2 border-white">Chat</a>
                <a href="#" class="hover:text-gray-300 transition duration-300">About</a>
                <a href="#" class="hover:text-gray-300 transition duration-300">Contact</a>
            </nav> --}}

            <div class="hidden md:flex items-center relative" x-data="{ userMenuOpen: false }">
    <button @click="userMenuOpen = !userMenuOpen" class="hover:text-gray-300 transition duration-300 flex items-center space-x-1 focus:outline-none">
        <span>Dhamar</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <!-- User Dropdown Menu -->
    <div 
        x-show="userMenuOpen" 
        @click.away="userMenuOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
        
        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profile</span>
            </div>
        </a>
        
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </div>
        </a>
        
        <div class="border-t border-gray-100 my-1"></div>
        
        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </div>
        </a>
    </div>
</div>
        </div>
    
        <!-- Mobile nav (controlled by Alpine.js) -->
        <nav class="md:hidden px-4 pb-4 bg-gray-800" x-show="mobileMenuOpen" x-transition>
            {{-- <a href="/" class="block py-2 hover:text-gray-300">Home</a>
            <a href="#" class="block py-2 hover:text-gray-300 font-bold">Chat</a>
            <a href="#" class="block py-2 hover:text-gray-300">About</a>
            <a href="#" class="block py-2 hover:text-gray-300">Contact</a> --}}
            
            {{-- @auth --}}
<div x-data="{ mobileUserMenuOpen: false }" class="block py-2 hover:text-gray-300 pt-5">
    <button @click="mobileUserMenuOpen = !mobileUserMenuOpen" class="flex items-center justify-between w-full">
        <span>Dhamar</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="mobileUserMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <div 
        x-show="mobileUserMenuOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="mt-2 pl-4 border-l border-gray-700">
        
        <a href="/profile" class="block py-2 text-sm text-gray-300 hover:text-white transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profile</span>
            </div>
        </a>
        
        <a href="#" class="block py-2 text-sm text-gray-300 hover:text-white transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </div>
        </a>
        
        <a href="#" class="block py-2 text-sm text-red-400 hover:text-red-300 transition duration-150 ease-in-out">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </div>
        </a>
    </div>
</div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col md:flex-row pt-16">
        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="mobileSidebarOpen" 
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>
        
        <!-- Sidebar -->
        <aside 
            class="bg-white w-full md:w-80 lg:w-96 border-r border-gray-200 flex-shrink-0 fixed md:sticky top-0 bottom-0 left-0 z-40 md:z-0 transform sidebar-transition h-full md:h-auto md:translate-x-0 pt-2"
            :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex flex-col h-full">
                <!-- New Chat Button -->
                <div class="p-4 border-b border-gray-200">
                    <button 
                        @click="startNewChat"
                        class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Mulai Percakapan Baru
                    </button>
                </div>
                
                <!-- Conversations -->
                <div class="p-4 border-b border-gray-200 overflow-hidden">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Percakapan Terbaru</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <template x-for="conversation in conversations" :key="conversation.id">
                            <div 
                                class="p-3 rounded-lg cursor-pointer conversation-item flex justify-between items-center"
                                :class="conversation.active ? 'bg-gray-100' : ''">
                                <div 
                                    @click="selectConversation(conversation.id)"
                                    class="flex items-center flex-1">
                                    <div class="mr-3 bg-gray-200 rounded-full p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800" x-text="conversation.title"></h4>
                                        <p class="text-xs text-gray-500" x-text="conversation.date"></p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div x-show="conversation.active" class="w-2 h-2 bg-gray-600 rounded-full mr-2"></div>
                                    <button 
                                        @click.stop="confirmDeleteConversation(conversation.id)" 
                                        class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Popular Topics -->
                <div class="p-4 flex-1 overflow-hidden">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Topik Populer</h3>
                    <div class="grid grid-cols-1 gap-2 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <template x-for="topic in topics" :key="topic.id">
                            <div 
                                @click="selectTopic(topic)"
                                class="p-3 bg-gray-50 rounded-lg cursor-pointer topic-item">
                                <div class="flex items-center">
                                    <div class="mr-3 bg-gray-200 rounded-full p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-700" x-text="topic.title"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="p-4 border-t border-gray-200">
    <div class="flex items-center">
        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <p class="font-medium text-gray-800">Dhamar</p>
            <p class="text-xs text-gray-500">Dhamar@gmail.com</p>
        </div>
        <a href="/profile" class="ml-auto text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
    </div>
</div>
            </div>
        </aside>
        
        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-gray-50 min-h-screen">
            <!-- Chat Header -->
            <div class="bg-white border-b border-gray-200 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="mr-3 bg-gray-100 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">SurabayaAI Assistant <span class="text-sm text-green-400">Online</span></h2>
                        <p class="text-sm text-gray-500">Tanyakan apa saja tentang sejarah Surabaya</p>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto custom-scrollbar">
                <!-- Welcome Message -->
                <div x-show="messages.length === 0" class="flex flex-col items-center justify-center h-full text-center px-4 fade-in" x-intersect="$el.classList.add('appear')">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Selamat Datang di SurabayaAI</h3>
                    <p class="text-gray-600 mb-8 max-w-md">Tanyakan apa saja tentang sejarah Surabaya, tokoh-tokoh penting, atau peristiwa bersejarah yang terjadi di kota pahlawan ini.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-w-lg">
                        <button @click="newMessage = 'Ceritakan tentang asal-usul nama Surabaya'; sendMessage()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg text-left transition duration-300 transform hover:-translate-y-1">
                            Asal-usul nama Surabaya
                        </button>
                        <button @click="newMessage = 'Siapa saja tokoh penting dalam Pertempuran 10 November?'; sendMessage()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg text-left transition duration-300 transform hover:-translate-y-1">
                            Tokoh Pertempuran 10 November
                        </button>
                        <button @click="newMessage = 'Apa saja tempat bersejarah di Surabaya?'; sendMessage()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg text-left transition duration-300 transform hover:-translate-y-1">
                            Tempat bersejarah di Surabaya
                        </button>
                        <button @click="newMessage = 'Bagaimana peran Surabaya dalam kemerdekaan Indonesia?'; sendMessage()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg text-left transition duration-300 transform hover:-translate-y-1">
                            Peran dalam kemerdekaan
                        </button>
                    </div>
                </div>
                
                <!-- Message List -->
                <template x-for="(message, index) in messages" :key="message.id">
                    <div 
                        :class="message.sender === 'user' ? 'flex justify-end mb-4' : 'flex justify-start mb-4'"
                        class="message-in"
                        x-intersect="$el.classList.add('appear')">
                        
                        <!-- AI Message -->
                        <template x-if="message.sender === 'ai'">
                            <div class="flex max-w-3xl">
                                <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center mr-2 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <p class="text-gray-800 whitespace-pre-line" x-text="message.text"></p>
                                </div>
                            </div>
                        </template>
                        
                        <!-- User Message -->
                        <template x-if="message.sender === 'user'">
                            <div class="bg-gray-600 text-white p-4 rounded-lg shadow-sm max-w-3xl">
                                <p x-text="message.text"></p>
                            </div>
                        </template>
                    </div>
                </template>
                
                <!-- AI is typing indicator -->
                <div x-show="isTyping" class="flex justify-start mb-4 message-in appear">
                    <div class="flex max-w-3xl">
                        <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center mr-2 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex space-x-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Input Area -->
            <div class="bg-white border-t border-gray-200 p-4">
                <form @submit.prevent="sendMessage" class="flex items-center">
                    <input 
                        id="message-input"
                        type="text" 
                        x-model="newMessage" 
                        placeholder="Tanyakan tentang sejarah Surabaya..." 
                        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300"
                        :disabled="isTyping">
                    
                    <button 
                        type="submit" 
                        class="ml-3 bg-gray-600 hover:bg-gray-700 text-white p-3 rounded-lg transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="newMessage.trim() === '' || isTyping">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
                <div class="mt-2 text-xs text-gray-500 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>SurabayaAI memberikan informasi berdasarkan data sejarah yang terverifikasi</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} SurabayaAI. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

<!-- Delete Confirmation Modal -->
<div 
    x-show="showDeleteModal" 
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
        
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Delete Conversation</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this conversation? This action cannot be undone.</p>
        
        <div class="flex justify-end space-x-3">
            <button 
                @click="showDeleteModal = false" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition duration-200">
                Cancel
            </button>
            <button 
                @click="deleteConversation()" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200">
                Delete
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatApp', () => ({
            mobileMenuOpen: false,
            mobileSidebarOpen: false,
            messages: [
                { id: 1, sender: 'user', text: 'Ceritakan tentang Pertempuran 10 November di Surabaya.' },
                { id: 2, sender: 'ai', text: 'Pertempuran 10 November 1945 atau dikenal sebagai Pertempuran Surabaya adalah salah satu pertempuran terbesar dan terpenting dalam Revolusi Nasional Indonesia. Pertempuran ini terjadi di kota Surabaya, Jawa Timur, antara pasukan Indonesia melawan pasukan Britania Raya dan India Britania.' },
                { id: 3, sender: 'user', text: 'Siapa tokoh penting dalam pertempuran tersebut?' },
                { id: 4, sender: 'ai', text: 'Beberapa tokoh penting dalam Pertempuran 10 November 1945 adalah:\n\n1. Bung Tomo (Sutomo) - Pemimpin perjuangan yang terkenal dengan pidato-pidato berapi-apinya melalui radio untuk membakar semangat perjuangan rakyat Surabaya.\n\n2. Gubernur Suryo - Gubernur Jawa Timur saat itu yang menolak ultimatum Inggris.\n\n3. Brigadir Jenderal A.W.S. Mallaby - Komandan pasukan Inggris yang tewas dalam insiden sebelum pertempuran besar.' }
            ],
            conversations: [
                { id: 1, title: 'Pertempuran 10 November', date: '2 hari lalu', active: true },
                { id: 2, title: 'Sejarah Tugu Pahlawan', date: '1 minggu lalu', active: false },
                { id: 3, title: 'Asal-usul nama Surabaya', date: '2 minggu lalu', active: false },
                { id: 4, title: 'Peran Surabaya dalam kemerdekaan', date: '1 bulan lalu', active: false }
            ],
            topics: [
                { id: 1, title: 'Tokoh Pahlawan Surabaya' },
                { id: 2, title: 'Monumen Bersejarah' },
                { id: 3, title: 'Peristiwa Penting di Surabaya' },
                { id: 4, title: 'Budaya dan Tradisi Surabaya' },
                { id: 5, title: 'Kuliner Khas Surabaya' }
            ],
            newMessage: '',
            isTyping: false,
            currentText: '',
            typingSpeed: 30,
            showDeleteModal: false,
            conversationToDelete: null,
        
            init() {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
        
            confirmDeleteConversation(id) {
                this.conversationToDelete = id;
                this.showDeleteModal = true;
            },
        
            deleteConversation() {
                if (this.conversationToDelete) {
                    // Find the conversation to delete
                    const index = this.conversations.findIndex(c => c.id === this.conversationToDelete);
                
                    if (index !== -1) {
                        // Check if it's the active conversation
                        const wasActive = this.conversations[index].active;
                    
                        // Remove the conversation
                        this.conversations.splice(index, 1);
                    
                        // If it was active, select another conversation or start a new chat
                        if (wasActive) {
                            if (this.conversations.length > 0) {
                                this.selectConversation(this.conversations[0].id);
                            } else {
                                this.startNewChat();
                            }
                        }
                    }
                
                    // Close the modal
                    this.showDeleteModal = false;
                    this.conversationToDelete = null;
                }
            },
        
            sendMessage() {
                if (this.newMessage.trim() === '') return;
                
                // Add user message
                this.messages.push({
                    id: this.messages.length + 1,
                    sender: 'user',
                    text: this.newMessage
                });
                
                const userQuestion = this.newMessage;
                this.newMessage = '';
                
                // Scroll to bottom
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
                
                // Simulate AI thinking
                this.isTyping = true;
                
                // Simulate AI response after delay
                setTimeout(() => {
                    this.isTyping = false;
                    
                    // Add AI response
                    const aiResponse = this.getAIResponse(userQuestion);
                    this.messages.push({
                        id: this.messages.length + 1,
                        sender: 'ai',
                        text: aiResponse
                    });
                    
                    // Scroll to bottom
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                }, 2000);
            },
            
            getAIResponse(question) {
                // This is a simple simulation - in a real app, you'd call your backend API
                const responses = {
                    'default': 'Terima kasih atas pertanyaan Anda tentang sejarah Surabaya. Saya akan mencoba menjawab dengan informasi yang akurat berdasarkan data sejarah yang tersedia.',
                    'siapa': 'Surabaya memiliki banyak tokoh penting dalam sejarahnya, termasuk Bung Tomo yang memimpin perlawanan pada Pertempuran 10 November 1945, dan Gubernur Suryo yang menjadi pemimpin pemerintahan saat itu.',
                    'apa': 'Surabaya adalah kota terbesar kedua di Indonesia dan memiliki peran penting dalam sejarah kemerdekaan Indonesia. Kota ini dijuluki Kota Pahlawan karena perjuangan rakyatnya melawan penjajah.',
                    'kapan': 'Pertempuran Surabaya terjadi pada tanggal 10 November 1945, yang kini diperingati sebagai Hari Pahlawan di Indonesia.',
                    'dimana': 'Beberapa lokasi bersejarah di Surabaya antara lain Tugu Pahlawan, Hotel Majapahit (dulu Hotel Oranje), Jembatan Merah, dan Monumen Kapal Selam.',
                    'mengapa': 'Surabaya menjadi pusat perlawanan karena semangat juang rakyatnya yang tinggi dan posisi strategisnya sebagai kota pelabuhan penting di Jawa Timur.'
                };
                
                // Simple keyword matching
                for (const [keyword, response] of Object.entries(responses)) {
                    if (question.toLowerCase().includes(keyword)) {
                        return response;
                    }
                }
                
                return responses.default;
            },
            
            scrollToBottom() {
                const chatContainer = document.getElementById('chat-messages');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            },
            
            selectConversation(id) {
                this.conversations.forEach(conv => {
                    conv.active = (conv.id === id);
                });
                
                // In a real app, you would load the conversation history here
                // For demo, we'll just reset messages
                if (id === 1) {
                    this.messages = [
                        { id: 1, sender: 'user', text: 'Ceritakan tentang Pertempuran 10 November di Surabaya.' },
                        { id: 2, sender: 'ai', text: 'Pertempuran 10 November 1945 atau dikenal sebagai Pertempuran Surabaya adalah salah satu pertempuran terbesar dan terpenting dalam Revolusi Nasional Indonesia. Pertempuran ini terjadi di kota Surabaya, Jawa Timur, antara pasukan Indonesia melawan pasukan Britania Raya dan India Britania.' },
                        { id: 3, sender: 'user', text: 'Siapa tokoh penting dalam pertempuran tersebut?' },
                        { id: 4, sender: 'ai', text: 'Beberapa tokoh penting dalam Pertempuran 10 November 1945 adalah:\n\n1. Bung Tomo (Sutomo) - Pemimpin perjuangan yang terkenal dengan pidato-pidato berapi-apinya melalui radio untuk membakar semangat perjuangan rakyat Surabaya.\n\n2. Gubernur Suryo - Gubernur Jawa Timur saat itu yang menolak ultimatum Inggris.\n\n3. Brigadir Jenderal A.W.S. Mallaby - Komandan pasukan Inggris yang tewas dalam insiden sebelum pertempuran besar.' }
                    ];
                } else if (id === 2) {
                    this.messages = [
                        { id: 1, sender: 'user', text: 'Apa itu Tugu Pahlawan?' },
                        { id: 2, sender: 'ai', text: 'Tugu Pahlawan adalah sebuah monumen yang terletak di pusat kota Surabaya. Monumen ini dibangun untuk memperingati peristiwa Pertempuran 10 November 1945 dan para pahlawan yang gugur dalam perjuangan mempertahankan kemerdekaan Indonesia.' }
                    ];
                } else if (id === 3) {
                    this.messages = [
                        { id: 1, sender: 'user', text: 'Dari mana asal nama Surabaya?' },
                        { id: 2, sender: 'ai', text: 'Nama Surabaya berasal dari kata "sura" (hiu) dan "baya" (buaya), yang merujuk pada legenda pertempuran antara kedua hewan tersebut. Legenda ini melambangkan pertempuran antara pasukan Raden Wijaya dari Kerajaan Majapahit melawan pasukan Mongol pada abad ke-13.' }
                    ];
                } else {
                    this.messages = [
                        { id: 1, sender: 'user', text: 'Bagaimana peran Surabaya dalam kemerdekaan Indonesia?' },
                        { id: 2, sender: 'ai', text: 'Surabaya memiliki peran yang sangat penting dalam perjuangan kemerdekaan Indonesia. Kota ini menjadi simbol perlawanan rakyat Indonesia terhadap penjajah melalui Pertempuran 10 November 1945. Peristiwa ini menunjukkan tekad dan semangat juang rakyat Indonesia untuk mempertahankan kemerdekaan, sehingga Surabaya dijuluki sebagai Kota Pahlawan.' }
                    ];
                }
                
                // Close mobile sidebar after selection
                this.mobileSidebarOpen = false;
                
                // Scroll to bottom
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            
            selectTopic(topic) {
                this.newMessage = topic.title;
                // Focus on input
                this.$nextTick(() => {
                    document.getElementById('message-input').focus();
                });
                
                // Close mobile sidebar after selection
                this.mobileSidebarOpen = false;
            },
            
            startNewChat() {
                // Reset messages
                this.messages = [];
                
                // Reset active conversation
                this.conversations.forEach(conv => {
                    conv.active = false;
                });
                
                // Close mobile sidebar
                this.mobileSidebarOpen = false;
            }
        }));
    });
</script>
</body>
</html>
