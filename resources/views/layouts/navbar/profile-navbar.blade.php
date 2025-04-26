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
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="cursor-pointer md:hidden transition-transform duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Desktop nav -->
        <nav class="hidden md:flex space-x-6">
            <a href="/" class="hover:text-gray-300 transition duration-300">Home</a>
            <a href="/chat" class="hover:text-gray-300 transition duration-300">Chat</a>
            <a href="#" class="border-b-2 border-white">Profile</a>
        </nav>
    </div>

    <!-- Mobile nav (controlled by Alpine.js) -->
    <nav class="md:hidden px-4 pb-4 bg-gray-800" x-show="mobileMenuOpen" x-transition>
        <a href="/" class="block py-2 hover:text-gray-300">Home</a>
        <a href="/chat" class="block py-2 hover:text-gray-300">Chat</a>
        <a href="#" class="block py-2 hover:text-gray-300 font-bold">Profile</a>
    </nav>
</header>