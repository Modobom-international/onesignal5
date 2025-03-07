<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MODOBOM') }} - {{ __('Hệ thống quản lý nội bộ') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>
        .nav-dropdown {
            transform-origin: top;
            transition: all 0.2s ease-out;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -1.5px;
            left: 0;
            right: 0;
            height: 2px;
            background: theme('colors.purple.600');
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }
        .nav-link-active:hover::after {
            transform: scaleX(1);
        }
        .nav-item:hover .nav-dropdown {
            opacity: 1;
            transform: rotateX(0deg);
            visibility: visible;
        }

        /* Hero Section Animations */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Dashboard Animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Gradient Animation */
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white">
    <!-- Header -->
    @include('landing.header')

    <!-- Hero Section -->
    @include('landing.hero')

    <main>
        <!-- Features Section -->
        <div id="features">
            @include('landing.features')
        </div>

    </main>

    <!-- Footer -->
    @include('landing.footer')

    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('#mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>

    @livewireScripts
</body>

</html>

