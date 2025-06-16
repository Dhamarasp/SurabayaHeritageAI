@extends('layouts.chat')

@section('content')
<main class="flex-1 flex flex-col md:flex-row">
    <!-- Left Sidebar - Info Panel -->
    <div class="w-full md:w-1/3 lg:w-1/4 bg-gray-600 p-6 shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-white">SurabayaAI</h2>
            <button id="history-toggle" class="md:hidden bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <!-- Chat History Section -->
        <div id="chat-history-section" class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-white">Riwayat Percakapan</h3>
                <button id="new-chat-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-1 rounded-lg transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
            
            <div class="max-h-60 overflow-y-auto custom-scrollbar mb-4">
                <ul id="conversation-list" class="space-y-2">
                    @foreach($conversations as $conversation)
                        <li>
                            <button 
                                class="conversation-item text-left w-full px-3 py-2 rounded-lg {{ $conversation->id == $activeConversation->id ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-700 hover:bg-blue-50 hover:text-blue-600' }} transition duration-300 truncate"
                                data-conversation-id="{{ $conversation->id }}"
                            >
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <span class="truncate">{{ $conversation->title ?? 'Percakapan Baru' }}</span>
                                </div>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div id="topic-popular-section" class="mb-6">
            <h3 class="text-lg text-white font-semibold mb-2">Topik Populer</h3>
            <ul class="space-y-2">
                @foreach($popularTopics as $topic)
                <li>
                    <button class="topic-btn text-left w-full px-3 py-2 rounded-lg bg-green-50 hover:bg-green-100 text-gray-800 hover:text-gray-800 transition duration-300" data-topic="{{ $topic->question }}">
                        {{ $topic->display_text }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="hidden md:block">
            <img src="{{ asset('images/chat_image.png') }}" alt="Landmark Surabaya" class="rounded-lg shadow-md mb-4 float-animation">
            <p class="text-sm text-white italic">Jelajahi warisan budaya kaya Surabaya melalui percakapan.</p>
        </div>
    </div>
    
    <!-- Right Side - Chat Interface -->
    <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col h-[calc(100vh-72px)]">
        <!-- Chat Header -->
        <div class="bg-gray-300 p-4 shadow-sm border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">SurabayaAI Assistant</h3>
                    <p class="text-xs text-green-500 font-bold">Online</p>
                </div>
            </div>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-200 custom-scrollbar">
            @if(count($messages) > 0)
                @foreach($messages as $message)
                    <div class="mb-4 message-animation">
                        @if($message->role == 'user')
                            <div class="flex items-start justify-end">
                                <div class="bg-red-100 rounded-lg p-3 shadow-sm max-w-[80%]">
                                    <p class="text-gray-800">{{ $message->content }}</p>
                                    <p class="text-xs text-gray-500 text-right mt-1">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-red-400 flex items-center justify-center text-white ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-600 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div class="bg-gray-100 rounded-lg p-3 shadow-sm max-w-[80%]">
                                    <p class="text-gray-800">{{ $message->content }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            @if($message->source == 'gemini')
                                <div class="text-xs text-gray-500 italic text-right mt-1 mr-12">Sumber: API Gemini</div>
                            @endif
                        @endif
                    </div>
                @endforeach
            @else
                <!-- Welcome message will be added by JavaScript -->
            @endif
        </div>
        
        <!-- Chat Input -->
        <div class="bg-gray-300 p-4 border-t border-gray-200">
            <form id="chat-form" class="flex items-center">
                <input type="hidden" id="active-conversation-id" value="{{ $activeConversation->id }}">
                <input id="chat-input" type="text" placeholder="Tanyakan tentang sejarah Surabaya..." class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent" />
                <button id="send-button" type="submit" class="ml-2 bg-gray-600 hover:bg-gray-700 text-white p-3 rounded-lg transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2">Contoh: "Apa asal usul nama Surabaya?" atau "Siapa Bung Tomo?"</p>
        </div>
    </div>
</main>
@endsection
