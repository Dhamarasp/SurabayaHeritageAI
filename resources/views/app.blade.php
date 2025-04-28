<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SurabayaAI - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('style')
</head>
<body class="bg-white text-gray-800 min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false, scrollHandler() { 
    return {
        scrollToSection(event, sectionId) {
            event.preventDefault();
            const section = document.querySelector(sectionId);
            if (section) {
                window.scrollTo({
                    top: section.offsetTop - 80,
                    behavior: 'smooth'
                });
                // Close mobile menu if open
                this.mobileMenuOpen = false;
            }
        }
    }
}}">
    <x-toast />
    <!-- Navbar -->
    @if (request()->is('login'))
        @include('layouts.navbar.auth-navbar')
    @elseif(request()->is('chat'))
        @include('layouts.navbar.chat-navbar')
    @elseif(request()->is('profile')) 
        @include('layouts.navbar.profile-navbar')
    @else
        @include('layouts.navbar.home-navbar')
    @endif

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @if (request()->is('/'))
        @include('layouts.footer.home-footer')
    @else
        @include('layouts.footer.common-footer')
    @endif

    @yield('script')
    
</body>
</html>
    