<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SurabayaAI - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('style')
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col" x-data="{ ...scrollHandler(), sidebarOpen: window.innerWidth >= 768 }">
    <x-toast />
    <!-- Admin Header -->
    @include('admin.layouts.navbar')

    <div class="flex flex-1 pt-16">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-6 md:ml-64">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    @include('admin.layouts.footer')

    @yield('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('scrollHandler', () => ({
                scrollToSection(event, sectionId) {
                    event.preventDefault();
                    const section = document.querySelector(sectionId);
                    if (section) {
                        window.scrollTo({
                            top: section.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }
            }));
        });
    </script>
</body>
</html>
