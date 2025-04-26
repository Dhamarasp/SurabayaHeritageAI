<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SurabayaAI - Your Guide to Surabaya's History</title>
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
        
        .stagger-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }
        
        .stagger-delay-1 { transition-delay: 0.1s; }
        .stagger-delay-2 { transition-delay: 0.2s; }
        .stagger-delay-3 { transition-delay: 0.3s; }
        
        /* Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Typing Animation - Updated for letter by letter */
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
        
        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ ...scrollHandler(), mobileMenuOpen: false }">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full z-50 bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <a href="#" class="text-2xl font-bold">SurabayaAI</a>
            </div>
    
            <!-- Hamburger for mobile -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="cursor-pointer md:hidden transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
    
            <!-- Desktop nav -->
            <nav class="hidden md:flex space-x-6">
                <a href="#features" @click="scrollToSection($event, '#features')" class="hover:text-gray-300 transition duration-300">Features</a>
                <a href="#how-it-works" @click="scrollToSection($event, '#how-it-works')" class="hover:text-gray-300 transition duration-300">How It Works</a>
                <a href="#examples" @click="scrollToSection($event, '#examples')" class="hover:text-gray-300 transition duration-300">Examples</a>
                <a href="#about" @click="scrollToSection($event, '#about')" class="hover:text-gray-300 transition duration-300">About</a>
            </nav>

            <div class="hidden md:flex items-center relative" x-data="{ userMenuOpen: false }">
    @auth
    <button @click="userMenuOpen = !userMenuOpen" class="hover:text-gray-300 transition duration-300 flex items-center space-x-1 focus:outline-none">
        <span>{{ Auth::user()->name }}</span>
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
        
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
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
    @endauth
    @guest
    <a href="/auth" class="hover:text-gray-300 transition duration-300">Login</a>
    @endguest
</div>
        </div>
    
        <!-- Mobile nav (controlled by Alpine.js) -->
        <nav class="md:hidden px-4 pb-4 bg-gray-800" x-show="mobileMenuOpen" x-transition>
            <a href="#features" @click="scrollToSection($event, '#features')" class="block py-2 hover:text-gray-300">Features</a>
            <a href="#how-it-works" @click="scrollToSection($event, '#how-it-works')" class="block py-2 hover:text-gray-300">How It Works</a>
            <a href="#examples" @click="scrollToSection($event, '#examples')" class="block py-2 hover:text-gray-300">Examples</a>
            <a href="#about" @click="scrollToSection($event, '#about')" class="block py-2 hover:text-gray-300">About</a>

            @auth
<div x-data="{ mobileUserMenuOpen: false }" class="block py-2 hover:text-gray-300 pt-5">
    <button @click="mobileUserMenuOpen = !mobileUserMenuOpen" class="flex items-center justify-between w-full">
        <span>{{ Auth::user()->name }}</span>
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
        
        <a href="#" class="block py-2 text-sm text-gray-300 hover:text-white transition duration-150 ease-in-out">
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
@endauth
@guest
<a href="/auth" class="block py-2 hover:text-gray-300 pt-5">Login</a>
@endguest

        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-gray-600 to-gray-800 text-white py-20 overflow-hidden">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center pt-1">
            <div class="md:w-1/2 mb-10 md:mb-0 fade-in" x-intersect="$el.classList.add('appear')">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Discover Surabaya's Rich History with AI</h2>
                <p class="text-xl mb-8">Ask any question about Surabaya's past and get accurate, insightful answers powered by advanced AI technology.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('chat') }}" class="bg-white text-gray-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-center transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">Try Now</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('images/hero_image.png') }}" alt="Surabaya City Illustration" class="rounded-lg max-w-2xl h-auto float-animation">
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-200">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16 fade-in" x-intersect="$el.classList.add('appear')">Why Choose SurabayaAI?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="bg-gray-100 p-8 rounded-xl shadow-md hover:shadow-lg transition duration-500 transform hover:-translate-y-2 stagger-item stagger-delay-1" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 100)">
                    <div class="bg-gray-200 p-3 rounded-full w-16 h-16 flex items-center justify-center mb-6 transition-all duration-300 hover:bg-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Comprehensive Knowledge</h3>
                    <p class="text-gray-600">Access detailed information about Surabaya's history, from ancient times to modern developments.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gray-100 p-8 rounded-xl shadow-md hover:shadow-lg transition duration-500 transform hover:-translate-y-2 stagger-item stagger-delay-2" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 200)">
                    <div class="bg-gray-200 p-3 rounded-full w-16 h-16 flex items-center justify-center mb-6 transition-all duration-300 hover:bg-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Natural Conversations</h3>
                    <p class="text-gray-600">Ask questions in your own words and receive conversational, easy-to-understand responses.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-gray-100 p-8 rounded-xl shadow-md hover:shadow-lg transition duration-500 transform hover:-translate-y-2 stagger-item stagger-delay-3" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 300)">
                    <div class="bg-gray-200 p-3 rounded-full w-16 h-16 flex items-center justify-center mb-6 transition-all duration-300 hover:bg-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Verified Information</h3>
                    <p class="text-gray-600">All historical data is carefully researched and verified by historians and local experts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16 fade-in" x-intersect="$el.classList.add('appear')">How SurabayaAI Works</h2>
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="w-full lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8 transition-all duration-300 hover:shadow-lg fade-in" x-intersect="$el.classList.add('appear')">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-100 text-gray-600 rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 transition-all duration-300 hover:bg-red-200 flex-shrink-0">1</div>
                            <h3 class="text-xl font-semibold">Ask Your Question</h3>
                        </div>
                        <p class="text-gray-600 ml-12">Type any question about Surabaya's history in the chat box.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8 transition-all duration-300 hover:shadow-lg fade-in" x-intersect="$el.classList.add('appear')">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-100 text-gray-600 rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 transition-all duration-300 hover:bg-red-200 flex-shrink-0">2</div>
                            <h3 class="text-xl font-semibold">AI Processing</h3>
                        </div>
                        <p class="text-gray-600 ml-12">Our advanced AI analyzes your question and searches its extensive knowledge base.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg fade-in" x-intersect="$el.classList.add('appear')">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-100 text-gray-600 rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 transition-all duration-300 hover:bg-red-200 flex-shrink-0">3</div>
                            <h3 class="text-xl font-semibold">Get Your Answer</h3>
                        </div>
                        <p class="text-gray-600 ml-12">Receive a detailed, accurate response with relevant historical information.</p>
                    </div>
                </div>
                
                <div class="w-full lg:w-1/2 fade-in" x-intersect="$el.classList.add('appear')">
                    <div class="bg-gray-100 rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl max-w-md mx-auto lg:max-w-full">
                        <div class="bg-gray-800 px-6 py-4 flex items-center">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="text-white text-sm mx-auto">SurabayaAI Chat</div>
                        </div>
                        <div class="p-6 bg-gray-100 h-80 overflow-y-auto">
                            <div class="bg-white rounded-lg p-4 mb-4 shadow-sm transform transition-transform duration-300 hover:-translate-y-1">
                                <p class="text-gray-800"><span class="font-semibold">You:</span><br> When was the Battle of Surabaya?</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm transform transition-transform duration-300 hover:-translate-y-1">
                                <p class="text-gray-800">
                                    <span class="font-semibold text-gray-800">SurabayaAI:</span>
                                    <br> 
                                    <span class="typing-container" 
                                          x-data="{
                                            text: 'The Battle of Surabaya took place on November 10, 1945. It was a fight between Indonesian nationalists and British-Indian troops as part of the Indonesian National Revolution.',
                                            displayedText: '',
                                            currentIndex: 0,
                                            typingSpeed: 50,
                                            typeNextChar() {
                                                if (this.currentIndex < this.text.length) {
                                                    this.displayedText += this.text[this.currentIndex];
                                                    this.currentIndex++;
                                                    setTimeout(() => this.typeNextChar(), this.typingSpeed);
                                                }
                                            }
                                          }" 
                                          x-init="setTimeout(() => typeNextChar(), 1000)">
                                        <span class="typing-text" x-text="displayedText"></span>
                                        <span class="typing-cursor" x-show="currentIndex < text.length">|</span>
                                    </span>
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Try It Now Section -->
    <section id="try-now" class="py-20 bg-gray-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8 fade-in" x-intersect="$el.classList.add('appear')">Experience SurabayaAI Now</h2>
            <p class="text-xl mb-10 max-w-3xl mx-auto fade-in" x-intersect="$el.classList.add('appear')">Ask your first question about Surabaya's history and discover the power of AI-driven historical knowledge.</p>
            
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden fade-in pulse-animation" x-intersect="$el.classList.add('appear')">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <input type="text" placeholder="Ask about Surabaya's history..." class="text-black w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300" />
                        <a href="" class="ml-4 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-gray-500 text-sm">Example questions: "Who founded Surabaya?", "What happened during the colonial period?", "Tell me about Surabaya's role in Indonesia's independence"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Examples Section -->
    <section id="examples" class="py-20 bg-gray-200">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16 fade-in" x-intersect="$el.classList.add('appear')">Popular Questions About Surabaya</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Example 1 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-2 transform stagger-item stagger-delay-1" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 100)">
                    <h3 class="text-xl font-semibold mb-4 text-gray-600">What is the origin of Surabaya's name?</h3>
                    <p class="text-gray-700">The name "Surabaya" is believed to come from the words "sura" (shark) and "baya" (crocodile), referring to a legendary battle between these creatures that symbolizes the Mongol forces and Raden Wijaya's Majapahit forces in ancient times.</p>
                </div>
                
                <!-- Example 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-2 transform stagger-item stagger-delay-2" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 200)">
                    <h3 class="text-xl font-semibold mb-4 text-gray-600">What role did Surabaya play in Indonesia's independence?</h3>
                    <p class="text-gray-700">Surabaya was a crucial site during Indonesia's fight for independence. The Battle of Surabaya on November 10, 1945, became a symbol of Indonesian resistance against colonial powers and is now commemorated as Heroes' Day.</p>
                </div>
                
                <!-- Example 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-2 transform stagger-item stagger-delay-3" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 300)">
                    <h3 class="text-xl font-semibold mb-4 text-gray-600">Who was Bung Tomo?</h3>
                    <p class="text-gray-700">Sutomo, better known as Bung Tomo, was a prominent Indonesian independence activist who played a significant role during the Battle of Surabaya. His fiery radio broadcasts inspired the people of Surabaya to fight against British-Indian troops.</p>
                </div>
                
                <!-- Example 4 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-2 transform stagger-item stagger-delay-1" 
    x-intersect="setTimeout(() => { $el.style.opacity = '1'; $el.style.transform = 'translateY(0)'; }, 100)">
                    <h3 class="text-xl font-semibold mb-4 text-gray-600">What are Surabaya's most important historical sites?</h3>
                    <p class="text-gray-700">Surabaya has many historical sites including the Heroes Monument (Tugu Pahlawan), Hotel Majapahit (formerly Hotel Oranje), Submarine Monument (Monumen Kapal Selam), and the House of Sampoerna, which showcase different periods of the city's rich history.</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="chatbot.html" class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    Try the Full Chatbot Experience
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10 fade-in" x-intersect="$el.classList.add('appear')">
                    <h2 class="text-3xl font-bold mb-6">About SurabayaAI</h2>
                    <p class="text-gray-700 mb-6">SurabayaAI was created to preserve and share the rich historical heritage of Surabaya, Indonesia's second-largest city. Our mission is to make Surabaya's fascinating history accessible to everyone through the power of artificial intelligence.</p>
                    <p class="text-gray-700 mb-6">Our team of historians, AI specialists, and local experts have collaborated to build a comprehensive knowledge base that covers everything from ancient legends to modern developments.</p>
                    <p class="text-gray-700">Whether you're a student, researcher, tourist, or simply curious about Surabaya's past, SurabayaAI is your perfect companion for historical exploration.</p>
                </div>
                <div class="w-full md:w-1/2 fade-in px-4" x-intersect="$el.classList.add('appear')">
                    <img 
                        src="{{ asset('images/cityscape_image.jpg') }}" 
                        alt="Surabaya Cityscape" 
                        class="w-full max-w-md mx-auto rounded-lg shadow-xl h-auto transition-all duration-500 hover:shadow-2xl"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6 fade-in" x-intersect="$el.classList.add('appear')">Ready to Explore Surabaya's History?</h2>
            <p class="text-xl mb-10 max-w-3xl mx-auto fade-in" x-intersect="$el.classList.add('appear')">Join thousands of users who are discovering the fascinating stories of Surabaya through our AI-powered platform.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 fade-in" x-intersect="$el.classList.add('appear')">
                <a href="chatbot.html" class="bg-white text-gray-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">Start Chatting Now</a>
                <a href="#" class="border border-white text-white hover:bg-white hover:text-gray-600 px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="fade-in" x-intersect="$el.classList.add('appear')">
                    <div class="flex items-center space-x-2 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <h3 class="text-xl font-bold">SurabayaAI</h3>
                    </div>
                    <p class="text-gray-400">Your AI guide to Surabaya's rich historical heritage.</p>
                </div>
                
                <div class="fade-in" x-intersect="$el.classList.add('appear')">
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Home</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Features</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">How It Works</a></li>
                        <li><a href="#examples" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Examples</a></li>
                    </ul>
                </div>
                
                <div class="fade-in" x-intersect="$el.classList.add('appear')">
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Historical Archives</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">API Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300 hover:translate-x-1 inline-block transform">Help Center</a></li>
                    </ul>
                </div>
                
                <div class="fade-in" x-intersect="$el.classList.add('appear')">
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400 group-hover:text-white transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:info@surabayaai.com" class="text-gray-400 group-hover:text-white transition duration-300">info@surabayaai.com</a>
                        </li>
                        <li class="flex items-center group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400 group-hover:text-white transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-400 group-hover:text-white transition duration-300">+62 31 1234 5678</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <h5 class="text-sm font-semibold mb-3">Follow Us</h5>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition duration-300 transform hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition duration-300 transform hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for animations -->
    <script>
    // Alpine.js handles all animations and interactions
    document.addEventListener('alpine:init', () => {
        Alpine.data('scrollHandler', () => ({
            scrollToSection(event, sectionId) {
                event.preventDefault();
                const section = document.querySelector(sectionId);
                if (section) {
                    window.scrollTo({
                        top: section.offsetTop - 80, // Offset for the fixed header
                        behavior: 'smooth'
                    });
                    // Close mobile menu if open
                    this.mobileMenuOpen = false;
                }
            }
        }));
    });
    </script>
</body>
</html>
