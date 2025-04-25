<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SurabayaAI - Autentikasi</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Animation Classes */
        .slide-enter-active {
            transition: all 0.5s ease-out;
        }
        
        .slide-leave-active {
            transition: all 0.5s ease-in;
        }
        
        .slide-enter-from-right {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .slide-leave-to-left {
            transform: translateX(-100%);
            opacity: 0;
        }
        
        .slide-enter-from-left {
            transform: translateX(-100%);
            opacity: 0;
        }
        
        .slide-leave-to-right {
            transform: translateX(100%);
            opacity: 0;
        }
        
        /* Background Pattern */
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
                <a href="/" class="text-2xl font-bold">SurabayaAI</a>
            </div>

            <div class="flex items-center">
                <a href="/" class="hover:text-gray-300 transition duration-300 flex items-center group">
                    <span>Back</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-24 px-4" 
          x-data="{ 
              isLogin: true, 
              direction: 'right',
              toggleForm() {
                  this.direction = this.isLogin ? 'right' : 'left';
                  this.isLogin = !this.isLogin;
              }
          }">
        <div class="w-full max-w-4xl">
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

            <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Form Section -->
                <div class="w-full md:w-1/2 p-8 relative overflow-hidden">
                    <!-- Login Form -->
                    <div x-show="isLogin" 
                         x-transition:enter="slide-enter-active"
                         x-transition:enter-start="slide-enter-from-right"
                         x-transition:leave="slide-leave-active"
                         x-transition:leave-end="slide-leave-to-left">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-800">Login ke SurabayaAI</h2>
                            <p class="text-gray-600 mt-2">Masuk untuk menjelajahi sejarah Surabaya</p>
                        </div>

                        <form method="POST" action="">
                            @csrf

                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input placeholder="Masukkan Email" type="email" name="email" id="login-email" value="{{ old('email') }}" required autofocus
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input placeholder="Masukkan Password" type="password" name="password" id="login-password" required
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                                </div>
                                <a href="#" class="text-sm text-gray-600 hover:text-gray-800 transition duration-300">Lupa password?</a>
                            </div>

                            <div class="mb-6">
                                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 hover:shadow-md">
                                    Login
                                </button>
                            </div>

                            <div class="text-center text-sm">
                                <p class="text-gray-600">Belum punya akun? 
                                    <button type="button" @click="toggleForm()" class="text-blue-600 hover:text-gray-800 font-medium transition duration-300">
                                        Daftar sekarang
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div x-show="!isLogin" 
                         x-transition:enter="slide-enter-active"
                         x-transition:enter-start="slide-enter-from-left"
                         x-transition:leave="slide-leave-active"
                         x-transition:leave-end="slide-leave-to-right">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-800">Daftar di SurabayaAI</h2>
                            <p class="text-gray-600 mt-2">Buat akun untuk menjelajahi sejarah Surabaya</p>
                        </div>

                        <form method="POST" action="">
                            @csrf

                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input placeholder="Masukkan Nama" type="text" name="name" id="register-name" value="{{ old('name') }}" required
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input placeholder="Masukkan Email" type="email" name="email" id="register-email" value="{{ old('email') }}" required
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input placeholder="Masukkan Password" type="password" name="password" id="register-password" required
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input placeholder="Ulangi Password" type="password" name="password_confirmation" id="register-password-confirmation" required
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300">
                                </div>
                            </div>

                            <div class="mb-6">
                                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 hover:shadow-md">
                                    Daftar
                                </button>
                            </div>

                            <div class="text-center text-sm">
                                <p class="text-gray-600">Sudah punya akun? 
                                    <button type="button" @click="toggleForm()" class="text-blue-600 hover:text-gray-800 font-medium transition duration-300">
                                        Login
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Image Section -->
                <div class="hidden md:block md:w-1/2 bg-gray-600 relative overflow-hidden"
                     :class="{ 'order-first': !isLogin, 'order-last': isLogin }"
                     x-transition:enter="slide-enter-active"
                     x-transition:enter-start="slide-enter-from-right"
                     x-transition:leave="slide-leave-active"
                     x-transition:leave-end="slide-leave-to-left">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-600 to-gray-800 opacity-90"></div>
                    <div class="absolute inset-0 bg-pattern opacity-10"></div>
                    <div class="relative h-full flex flex-col justify-center items-center p-12 text-white">
                        <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div x-show="isLogin">
                            <h3 class="text-2xl font-bold mb-4 text-center">Jelajahi Sejarah Surabaya</h3>
                            <p class="text-center mb-6">Temukan kisah-kisah menarik tentang kota pahlawan dengan bantuan kecerdasan buatan.</p>
                        </div>
                        <div x-show="!isLogin">
                            <h3 class="text-2xl font-bold mb-4 text-center">Bergabunglah dengan Kami</h3>
                            <p class="text-center mb-6">Dapatkan akses ke informasi lengkap tentang sejarah kota Surabaya melalui teknologi AI.</p>
                        </div>
                        <div class="w-16 h-1 bg-white rounded-full opacity-50"></div>
                    </div>
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
</body>
</html>
