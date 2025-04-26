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
<p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
<p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
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