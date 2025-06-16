<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SurabayaAI - Eksplorasi Sejarah Surabaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Typing Animation */
        .typing-animation {
            display: inline-block;
            position: relative;
        }
        
        .typing-animation::after {
            content: '|';
            position: absolute;
            right: -4px;
            color: #ef4444;
            animation: cursor-blink 1s step-end infinite;
        }
        
        @keyframes cursor-blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        
        .typing-text {
            overflow: hidden;
            white-space: pre-wrap;
            word-break: break-word;
            animation: none;
            width: 0;
        }
        
        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 4s ease-in-out infinite;
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
            background: #ef4444;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d33030;
        }
        
        /* Message Animation */
        @keyframes message-appear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message-animation {
            animation: message-appear 0.3s ease-out forwards;
        }
        
        /* Sidebar Animation */
        .sidebar-enter {
            transform: translateX(-100%);
            transition: transform 0.3s ease-out;
        }
        
        .sidebar-enter-active {
            transform: translateX(0);
        }
        
        .sidebar-exit {
            transform: translateX(0);
            transition: transform 0.3s ease-in;
        }
        
        .sidebar-exit-active {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="mr-2 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 hover:opacity-90 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h1 class="text-xl font-bold">SurabayaAI</h1>
                </a>
            </div>
            @auth
            <div class="flex items-center space-x-4" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" class="flex items-center space-x-1 focus:outline-none cursor-pointer">
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                        x-transition>
                        <a href="{{ route('chat.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kembali ke Chat</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth            
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} SurabayaAI. Hak Cipta Dilindungi. <a href="/" class="text-blue-200 hover:text-white transition duration-300">Kembali ke Beranda</a></p>
        </div>
    </footer>

    <!-- Modal for Gemini API Permission -->
    <div id="permission-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Izin Penggunaan API Gemini</h3>
            <p class="text-gray-600 mb-6">Informasi yang Anda tanyakan tidak tersedia dalam database lokal kami. Apakah Anda mengizinkan SurabayaAI untuk mencari jawaban menggunakan API Gemini?</p>
            <div class="flex justify-end space-x-3">
                <button id="deny-permission" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition duration-300">Tidak</button>
                <button id="grant-permission" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300">Ya, Gunakan Gemini</button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const chatContainer = document.getElementById("chat-messages");
            const chatForm = document.getElementById("chat-form");
            const chatInput = document.getElementById("chat-input");
            const sendButton = document.getElementById("send-button");
            const topicButtons = document.querySelectorAll(".topic-btn");
            const permissionModal = document.getElementById("permission-modal");
            const grantPermissionBtn = document.getElementById("grant-permission");
            const denyPermissionBtn = document.getElementById("deny-permission");
            const newChatBtn = document.getElementById("new-chat-btn");
            const conversationItems = document.querySelectorAll(".conversation-item");
            const activeConversationId = document.getElementById("active-conversation-id");
            const historyToggle = document.getElementById("history-toggle");
            const chatHistorySection = document.getElementById("chat-history-section");
            const topicPopularSection = document.getElementById("topic-popular-section");
            
            // Current message for which permission is being requested
            let currentMessage = "";

            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Add event listeners
            chatForm.addEventListener("submit", handleSubmit);
            
            // Add event listeners to topic buttons
            topicButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    const topic = button.getAttribute("data-topic");
                    if (topic) {
                        chatInput.value = topic;
                        handleSubmit(new Event("submit"));
                    }
                });
            });
            
            // Permission modal buttons
            grantPermissionBtn.addEventListener("click", () => {
                permissionModal.classList.add("hidden");
                if (currentMessage) {
                    sendMessageToServer(currentMessage, true);
                }
            });
            
            denyPermissionBtn.addEventListener("click", () => {
                permissionModal.classList.add("hidden");
                addMessage("ai", "Maaf, saya tidak dapat menjawab pertanyaan tersebut tanpa menggunakan API Gemini. Silakan tanyakan hal lain tentang sejarah Surabaya yang mungkin ada dalam database lokal saya.");
            });
            
            // New chat button
            newChatBtn.addEventListener("click", createNewConversation);
            
            // Conversation items
            conversationItems.forEach(item => {
                item.addEventListener("click", () => {
                    loadConversation(item.getAttribute("data-conversation-id"));
                });
            });
            
            // History toggle for mobile
            historyToggle.addEventListener("click", () => {
                chatHistorySection.classList.toggle("hidden");
                topicPopularSection.classList.toggle("hidden");
            });

            // Handle form submission
            function handleSubmit(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (message) {
                    addMessage("user", message);
                    chatInput.value = "";
                    currentMessage = message;
                    sendMessageToServer(message);
                }
            }
            
            // Create new conversation
            function createNewConversation() {
                fetch("{{ route('chat.new') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        // Update active conversation ID
                        activeConversationId.value = data.conversation.id;
                        
                        // Clear chat messages
                        chatContainer.innerHTML = "";
                        
                        // Add welcome message
                        setTimeout(() => {
                            addMessage(
                                "ai",
                                "Halo! Saya SurabayaAI, pemandu Anda untuk menjelajahi sejarah kaya Surabaya. Apa yang ingin Anda ketahui tentang Surabaya hari ini?",
                                true,
                            );
                        }, 500);
                        
                        // Update conversation list
                        updateConversationList();
                    }
                })
                .catch(error => {
                    console.error("Error creating new conversation:", error);
                });
            }
            
            // Load conversation
            function loadConversation(conversationId) {
                fetch(`{{ url('chat/messages') }}/${conversationId}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update active conversation ID
                    activeConversationId.value = conversationId;
                    
                    // Clear chat messages
                    chatContainer.innerHTML = "";
                    
                    // Add messages
                    data.messages.forEach(message => {
                        if (message.role === "user") {
                            addMessage("user", message.content, false, message.created_at);
                        } else {
                            addMessage("ai", message.content, false, message.created_at, message.source);
                        }
                    });
                    
                    // Update conversation list UI
                    updateConversationListUI(conversationId);
                    
                    // Scroll to bottom
                    scrollToBottom();
                })
                .catch(error => {
                    console.error("Error loading conversation:", error);
                });
            }
            
            // Update conversation list
            function updateConversationList() {
                fetch("{{ route('chat.history') }}", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const conversationList = document.getElementById("conversation-list");
                    conversationList.innerHTML = "";
                    
                    data.conversations.forEach(conversation => {
                        const isActive = conversation.id == activeConversationId.value;
                        const li = document.createElement("li");
                        li.innerHTML = `
                            <button 
                                class="conversation-item text-left w-full px-3 py-2 rounded-lg ${isActive ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600'} transition duration-300 truncate"
                                data-conversation-id="${conversation.id}"
                            >
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <span class="truncate">${conversation.title || 'Percakapan Baru'}</span>
                                </div>
                            </button>
                        `;
                        
                        conversationList.appendChild(li);
                        
                        // Add event listener
                        const button = li.querySelector(".conversation-item");
                        button.addEventListener("click", () => {
                            loadConversation(conversation.id);
                        });
                    });
                })
                .catch(error => {
                    console.error("Error updating conversation list:", error);
                });
            }
            
            // Update conversation list UI
            function updateConversationListUI(activeId) {
                const conversationItems = document.querySelectorAll(".conversation-item");
                conversationItems.forEach(item => {
                    const itemId = item.getAttribute("data-conversation-id");
                    if (itemId == activeId) {
                        item.classList.add("bg-red-50", "text-red-600");
                        item.classList.remove("bg-gray-100", "text-gray-700", "hover:bg-red-50", "hover:text-red-600");
                    } else {
                        item.classList.remove("bg-red-50", "text-red-600");
                        item.classList.add("bg-gray-100", "text-gray-700", "hover:bg-red-50", "hover:text-red-600");
                    }
                });
            }
            
            // Send message to server
            function sendMessageToServer(message, useGemini = false) {
                // Show typing indicator
                showTypingIndicator();
                
                // Send request to server
                fetch("{{ route('chat.process') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        message: message,
                        use_gemini: useGemini,
                        conversation_id: activeConversationId.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Remove typing indicator
                    removeTypingIndicator();
                    
                    if (data.status === "need_permission") {
                        // Show permission modal
                        permissionModal.classList.remove("hidden");
                    } else if (data.status === "success") {
                        // Add AI response with typing effect
                        addMessage("ai", data.message, true, null, data.source);
                        
                        // Update conversation list if this is a new conversation
                        if (data.conversation_id) {
                            activeConversationId.value = data.conversation_id;
                            updateConversationList();
                        }
                    } else {
                        // Show error message
                        addMessage("ai", data.message || "Maaf, terjadi kesalahan. Silakan coba lagi.");
                    }
                    
                    // Scroll to bottom
                    scrollToBottom();
                })
                .catch(error => {
                    console.error("Error:", error);
                    removeTypingIndicator();
                    addMessage("ai", "Maaf, terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi.");
                    scrollToBottom();
                });
            }

            // Add message to chat
            function addMessage(sender, message, withTyping = false, timestamp = null, source = null) {
                const messageElement = document.createElement("div");
                messageElement.classList.add("mb-4", "message-animation");

                const time = timestamp ? new Date(timestamp).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }) : new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

                if (sender === "user") {
                    messageElement.innerHTML = `
                        <div class="flex items-start justify-end">
                            <div class="bg-red-100 rounded-lg p-3 shadow-sm max-w-[80%]">
                                <p class="text-gray-800">${message}</p>
                                <p class="text-xs text-gray-500 text-right mt-1">${time}</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    `;
                } else {
                    messageElement.innerHTML = `
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm max-w-[80%]">
                                <p class="text-gray-800">
                                    ${withTyping ? `<span class="typing-animation"><span class="typing-text">${message}</span></span>` : message}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">${time}</p>
                            </div>
                        </div>
                    `;
                    
                    // Add source indicator if from Gemini
                    if (source === "gemini") {
                        const sourceElement = document.createElement("div");
                        sourceElement.classList.add("text-xs", "text-gray-500", "italic", "text-right", "mt-1", "mr-12");
                        sourceElement.textContent = "Sumber: API Gemini";
                        messageElement.appendChild(sourceElement);
                    }
                }

                chatContainer.appendChild(messageElement);
                scrollToBottom();

                // Initialize typing animation if needed
                if (withTyping && sender === "ai") {
                    const typingText = messageElement.querySelector(".typing-text");
                    if (typingText) {
                        animateTyping(typingText, message);
                    }
                }
            }

            // Animate typing effect
            function animateTyping(element, text) {
                let i = 0;
                element.textContent = "";

                function type() {
                    if (i < text.length) {
                        element.textContent += text.charAt(i);
                        i++;

                        // Random typing speed for more realistic effect
                        const randomSpeed = Math.floor(Math.random() * 10) + 20;
                        setTimeout(type, randomSpeed);

                        // Scroll as typing happens
                        scrollToBottom();
                    }
                }

                type();
            }

            // Show typing indicator
            function showTypingIndicator() {
                const typingElement = document.createElement("div");
                typingElement.id = "typing-indicator";
                typingElement.classList.add("mb-4", "message-animation");
                typingElement.innerHTML = `
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <div class="flex space-x-2">
                                <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></div>
                                <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></div>
                                <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></div>
                            </div>
                        </div>
                    </div>
                `;
                chatContainer.appendChild(typingElement);
                scrollToBottom();
            }

            // Remove typing indicator
            function removeTypingIndicator() {
                const typingIndicator = document.getElementById("typing-indicator");
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }

            // Scroll chat to bottom
            function scrollToBottom() {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            // Add initial welcome message if no messages exist
            if (chatContainer.children.length === 0) {
                setTimeout(() => {
                    addMessage(
                        "ai",
                        "Halo! Saya SurabayaAI, pemandu Anda untuk menjelajahi sejarah kaya Surabaya. Apa yang ingin Anda ketahui tentang Surabaya hari ini?",
                        true,
                    );
                }, 1000);
            }
        });
    </script>
</body>
</html>
