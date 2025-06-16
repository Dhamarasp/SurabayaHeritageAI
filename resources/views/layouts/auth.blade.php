<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Autentikasi' }} - SurabayaAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full z-50 bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <a href="#" class="text-2xl font-bold">SurabayaAI</a>
            </div>

            <div class="flex items-center">
                <a href="/" class="hover:text-gray-300 transition duration-300">Kembali</a>
            </div>
        </div>
    
        <!-- Hidden checkbox for toggle -->
        <input type="checkbox" id="menu-toggle" class="hidden peer" />
    
        <!-- Mobile nav (shown when checkbox is checked) -->
        <nav class="peer-checked:block hidden md:hidden px-4 pb-4 bg-gray-800">
            <a href="#features" class="block py-2 hover:text-gray-300">Features</a>
            <a href="#how-it-works" class="block py-2 hover:text-gray-300">How It Works</a>
            <a href="#examples" class="block py-2 hover:text-gray-300">Examples</a>
            <a href="#about" class="block py-2 hover:text-gray-300">About</a>

            <a href="" class="block py-2 hover:text-gray-300 pt-5">Login</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} SurabayaAI. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
