@extends('app')

@section('title', '500 - Server Error')
    
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
    
    /* Custom 500 Animation */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .shake-animation {
        animation: shake 0.8s cubic-bezier(.36,.07,.19,.97) both;
    }

    /* SVG Animations */
    .svg-circle {
        stroke-dasharray: 628;
        stroke-dashoffset: 628;
        animation: circle-animation 3s ease-in-out forwards;
    }

    @keyframes circle-animation {
        to {
            stroke-dashoffset: 0;
        }
    }

    .gear-large {
        transform-origin: 120px 120px;
        animation: gear-spin 10s linear infinite;
    }

    .gear-small {
        transform-origin: 170px 90px;
        animation: gear-spin-reverse 7s linear infinite;
    }

    @keyframes gear-spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes gear-spin-reverse {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(-360deg);
        }
    }

    .sura-group {
        animation: sura-fix 6s ease-in-out infinite;
        transform-origin: 70px 100px;
    }

    @keyframes sura-fix {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-5px) rotate(-2deg);
        }
        75% {
            transform: translateY(5px) rotate(2deg);
        }
    }

    .baya-group {
        animation: baya-fix 7s ease-in-out infinite;
        transform-origin: 170px 130px;
    }

    @keyframes baya-fix {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(5px) rotate(2deg);
        }
        75% {
            transform: translateY(-5px) rotate(-2deg);
        }
    }

    .sura-arm, .baya-arm {
        animation: arm-movement 3s ease-in-out infinite;
        transform-origin: top center;
    }

    @keyframes arm-movement {
        0%, 100% {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(15deg);
        }
    }

    .sura-eye, .baya-eye {
        animation: blink-animation 4s ease-in-out infinite;
    }

    @keyframes blink-animation {
        0%, 45%, 55%, 100% {
            transform: scaleY(1);
        }
        50% {
            transform: scaleY(0.1);
        }
    }

    .wrench {
        animation: wrench-fix 2s ease-in-out infinite;
        transform-origin: 70px 140px;
    }

    @keyframes wrench-fix {
        0%, 100% {
            transform: rotate(0deg);
        }
        25%, 75% {
            transform: rotate(-20deg);
        }
        50% {
            transform: rotate(20deg);
        }
    }

    .screwdriver {
        animation: screwdriver-fix 1.5s ease-in-out infinite;
        transform-origin: 170px 90px;
    }

    @keyframes screwdriver-fix {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    .spark {
        opacity: 0;
        animation: spark-animation 2s ease-in-out infinite;
    }

    .spark-1 {
        animation-delay: 0s;
    }

    .spark-2 {
        animation-delay: 0.5s;
    }

    .spark-3 {
        animation-delay: 1s;
    }

    .spark-4 {
        animation-delay: 1.5s;
    }

    @keyframes spark-animation {
        0%, 100% {
            opacity: 0;
            transform: scale(0.8);
        }
        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    .progress-bar {
        stroke-dasharray: 150;
        stroke-dashoffset: 150;
        animation: progress-animation 3s ease-in-out infinite;
    }

    @keyframes progress-animation {
        0% {
            stroke-dashoffset: 150;
        }
        50% {
            stroke-dashoffset: 0;
        }
        50.1% {
            stroke-dashoffset: 150;
        }
        100% {
            stroke-dashoffset: 150;
        }
    }

    .error-code {
        animation: glitch 3s ease-in-out infinite;
    }

    @keyframes glitch {
        0%, 100% {
            transform: translate(0);
            text-shadow: 0 0 0 transparent;
        }
        5%, 15% {
            transform: translate(-2px, 2px);
            text-shadow: -2px 0 #ff00c1, 2px 2px #00ffff;
        }
        10%, 20% {
            transform: translate(2px, -2px);
            text-shadow: 2px 0 #00ffff, -2px -2px #ff00c1;
        }
        25% {
            transform: translate(0);
            text-shadow: 0 0 0 transparent;
        }
    }
</style>
@endsection

@section('content')
<!-- Main Content -->
<main class="flex-1 flex flex-col items-center justify-center py-16 px-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-4xl text-center">
        <!-- 500 Section -->
        <div class="bg-gradient-to-b from-gray-600 to-gray-800 text-white py-16 px-6 rounded-xl shadow-xl mb-8 fade-in" x-intersect="$el.classList.add('appear')">
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <h1 class="text-6xl md:text-8xl font-bold mb-4 error-code">500</h1>
                    <h2 class="text-2xl md:text-3xl font-semibold mb-4">Server Error</h2>
                    <p class="text-lg mb-8 text-gray-300">Maaf, server kami sedang mengalami masalah. Tim kami sedang bekerja untuk memperbaikinya.</p>
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
                    <div class="relative w-64 h-64">
                        <!-- Enhanced Sura and Baya (Shark and Crocodile) fixing server illustration -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" class="w-full h-full">
                            <!-- Background circle -->
                            <circle cx="120" cy="120" r="100" fill="none" stroke="white" stroke-width="2" class="svg-circle" />
                            
                            <!-- Server/Gears -->
                            <rect x="100" y="80" width="40" height="60" rx="5" fill="rgba(255,255,255,0.2)" stroke="white" stroke-width="2" />
                            <rect x="105" y="90" width="30" height="5" rx="2" fill="rgba(255,255,255,0.5)" />
                            <rect x="105" y="100" width="30" height="5" rx="2" fill="rgba(255,255,255,0.5)" />
                            <rect x="105" y="110" width="30" height="5" rx="2" fill="rgba(255,255,255,0.5)" />
                            
                            <!-- Progress bar -->
                            <rect x="45" y="160" width="150" height="10" rx="5" fill="rgba(255,255,255,0.2)" />
                            <path d="M45,165 L195,165" stroke="rgba(255,255,255,0.7)" stroke-width="6" stroke-linecap="round" class="progress-bar" />
                            
                            <!-- Gears -->
                            <g class="gear-large">
                                <circle cx="120" cy="120" r="20" fill="none" stroke="white" stroke-width="2" />
                                <path d="M120,100 L120,95 M120,140 L120,145 M100,120 L95,120 M140,120 L145,120 M105,105 L101,101 M135,135 L139,139 M105,135 L101,139 M135,105 L139,101" stroke="white" stroke-width="2" />
                            </g>
                            <g class="gear-small">
                                <circle cx="170" cy="90" r="15" fill="none" stroke="white" stroke-width="2" />
                                <path d="M170,75 L170,72 M170,105 L170,108 M155,90 L152,90 M185,90 L188,90 M160,80 L157,77 M180,100 L183,103 M160,100 L157,103 M180,80 L183,77" stroke="white" stroke-width="2" />
                            </g>
                            
                            <!-- Sura (Shark) fixing -->
                            <g class="sura-group">
                                <path d="M50,120 C40,110 45,90 60,85 C75,80 85,90 90,100 C95,110 90,120 85,125 C80,130 70,135 60,130 C50,125 45,120 50,120 Z" fill="rgba(255,255,255,0.7)" />
                                <circle cx="65" cy="95" r="3" fill="#333" class="sura-eye" />
                                <path d="M70,110 C72,112 75,112 77,110" fill="none" stroke="#333" stroke-width="1.5" />
                                <!-- Sura arm with wrench -->
                                <path d="M70,120 C75,130 80,140 70,140" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="4" class="sura-arm" />
                                <path d="M60,140 L80,140 L75,150 L65,150 Z" fill="rgba(255,255,255,0.9)" class="wrench" />
                            </g>
                            
                            <!-- Baya (Crocodile) fixing -->
                            <g class="baya-group">
                                <path d="M170,130 C180,120 175,100 160,95 C145,90 135,100 130,110 C125,120 130,130 135,135 C140,140 150,145 160,140 C170,135 175,130 170,130 Z" fill="rgba(255,255,255,0.7)" />
                                <circle cx="155" cy="105" r="3" fill="#333" class="baya-eye" />
                                <path d="M140,120 C142,123 148,123 150,120" fill="none" stroke="#333" stroke-width="1.5" />
                                <!-- Baya arm with screwdriver -->
                                <path d="M150,110 C160,100 170,90 170,90" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="4" class="baya-arm" />
                                <path d="M165,85 L175,95 L170,100 L160,90 Z" fill="rgba(255,255,255,0.9)" class="screwdriver" />
                            </g>
                            
                            <!-- Sparks -->
                            <circle cx="120" cy="120" r="5" fill="yellow" opacity="0.8" class="spark spark-1" />
                            <circle cx="170" cy="90" r="4" fill="yellow" opacity="0.8" class="spark spark-2" />
                            <circle cx="70" cy="140" r="4" fill="yellow" opacity="0.8" class="spark spark-3" />
                            <circle cx="120" cy="165" r="3" fill="yellow" opacity="0.8" class="spark spark-4" />
                            
                            <!-- Error text -->
                            <text x="120" y="60" fill="white" font-size="12" text-anchor="middle" font-family="monospace">ERROR 500</text>
                            <text x="120" y="200" fill="white" font-size="10" text-anchor="middle" font-family="monospace">REPAIRING...</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // Add interactive hover effect to the SVG
    document.addEventListener('DOMContentLoaded', function() {
        const svg = document.querySelector('svg');
        const suraGroup = document.querySelector('.sura-group');
        const bayaGroup = document.querySelector('.baya-group');
        
        if (svg && suraGroup && bayaGroup) {
            svg.addEventListener('mousemove', function(e) {
                const rect = svg.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Calculate distance from center of each character
                const suraX = 70;
                const suraY = 100;
                const bayaX = 170;
                const bayaY = 130;
                
                // Move slightly toward cursor for "fixing" behavior
                const suraAngle = Math.atan2(y - suraY, x - suraX);
                const bayaAngle = Math.atan2(y - bayaY, x - bayaX);
                
                const suraDistance = Math.min(5, Math.sqrt(Math.pow(x - suraX, 2) + Math.pow(y - suraY, 2)) / 20);
                const bayaDistance = Math.min(5, Math.sqrt(Math.pow(x - bayaX, 2) + Math.pow(y - bayaY, 2)) / 20);
                
                suraGroup.style.transform = `translate(${Math.cos(suraAngle) * suraDistance}px, ${Math.sin(suraAngle) * suraDistance}px)`;
                bayaGroup.style.transform = `translate(${Math.cos(bayaAngle) * bayaDistance}px, ${Math.sin(bayaAngle) * bayaDistance}px)`;
                
                // Add more sparks on click
                svg.addEventListener('click', function(e) {
                    // Create a temporary spark at click position
                    const spark = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                    spark.setAttribute("cx", x);
                    spark.setAttribute("cy", y);
                    spark.setAttribute("r", "5");
                    spark.setAttribute("fill", "yellow");
                    spark.setAttribute("opacity", "0.8");
                    spark.classList.add("spark");
                    
                    svg.appendChild(spark);
                    
                    // Remove the spark after animation
                    setTimeout(() => {
                        spark.remove();
                    }, 1000);
                });
            });
            
            svg.addEventListener('mouseleave', function() {
                suraGroup.style.transform = '';
                bayaGroup.style.transform = '';
            });
        }
    });
</script>
@endsection
