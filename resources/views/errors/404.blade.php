@extends('app')

@section('title', '404 - Page Not Found')
    
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
    
    /* Floating Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .float-animation {
        animation: float 4s ease-in-out infinite;
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
    
    /* Custom 404 Animation */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .shake-animation {
        animation: shake 0.8s cubic-bezier(.36,.07,.19,.97) both;
    }
</style>
@endsection

@section('content')
<!-- Main Content -->
<main class="flex-1 flex flex-col items-center justify-center py-16 px-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-4xl text-center">
        <!-- 404 Section -->
        <div class="bg-gradient-to-b from-gray-600 to-gray-800 text-white py-16 px-6 rounded-xl shadow-xl mb-8 fade-in" x-intersect="$el.classList.add('appear')">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <h1 class="text-6xl md:text-8xl font-bold mb-4 shake-animation">404</h1>
                    <h2 class="text-2xl md:text-3xl font-semibold mb-4">Halaman Tidak Ditemukan</h2>
                    <p class="text-lg mb-8 text-gray-300">Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('home') }}" class="bg-white text-gray-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('chat') }}" class="border border-white text-white hover:bg-white hover:text-gray-600 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            Mulai Chat
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative w-64 h-64 float-animation">
                        <!-- Stylized Sura and Baya (Shark and Crocodile) illustration -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-full h-full">
                            <path d="M100,20 C60,20 20,50 20,100 C20,150 60,180 100,180 C140,180 180,150 180,100 C180,50 140,20 100,20 Z" fill="none" stroke="white" stroke-width="2" />
                            <path d="M40,100 C40,80 60,70 80,70 C100,70 110,80 110,100 C110,120 100,130 80,130 C60,130 40,120 40,100 Z" fill="rgba(255,255,255,0.2)" />
                            <path d="M90,100 C90,80 110,70 130,70 C150,70 160,80 160,100 C160,120 150,130 130,130 C110,130 90,120 90,100 Z" fill="rgba(255,255,255,0.2)" />
                            <circle cx="70" cy="90" r="5" fill="white" />
                            <circle cx="140" cy="90" r="5" fill="white" />
                            <path d="M85,110 C90,115 110,115 115,110" fill="none" stroke="white" stroke-width="2" />
                            <path d="M30,70 L50,60 L45,80 Z" fill="white" />
                            <path d="M170,70 L150,60 L155,80 Z" fill="white" />
                        </svg>
                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center text-white text-lg font-bold">
                            Sura & Baya
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Suggestions Section -->
        {{-- <div class="bg-white rounded-lg shadow-md p-8 fade-in" x-intersect="$el.classList.add('appear')">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Mungkin Anda mencari:</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-4 rounded-lg flex items-center transition duration-300 transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('chat') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-4 rounded-lg flex items-center transition duration-300 transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Chat dengan AI
                </a>
                <a href="{{ route('profile') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-4 rounded-lg flex items-center transition duration-300 transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Pengguna
                </a>
            </div>
        </div> --}}
    </div>
</main>
@endsection
