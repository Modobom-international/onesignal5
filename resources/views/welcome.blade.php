<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MODOBOM') }} - {{ __('Giải pháp quản lý nhân sự toàn diện') }}</title>

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
            background: theme('colors.indigo.600');
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
    <header x-data="{ mobileMenuOpen: false }"
            class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm border-b border-gray-200"
            @scroll.window="$el.classList.toggle('shadow-sm', window.scrollY > 0)">
        <div class="relative">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="text-xl font-bold text-gray-900">Modobom</span>
                        </a>
                    </div>

                    <!-- Navigation Links - Desktop -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-8">
                        <!-- Products Dropdown -->
                        <div class="nav-item relative" x-data="{ open: false }">
                            <button @mouseenter="open = true" @mouseleave="open = false"
                                class="group inline-flex items-center text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                                {{ __('Sản phẩm') }}
                                <svg class="ml-1.5 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @mouseenter="open = true" @mouseleave="open = false"
                                class="nav-dropdown absolute -ml-4 mt-0 w-screen max-w-md transform px-2 opacity-0 invisible transform-gpu"
                                style="perspective: 2000px; transform: rotateX(-15deg);">
                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <a href="#" class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white sm:h-12 sm:w-12">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">{{ __('Tính năng') }}</p>
                                                <p class="mt-1 text-sm text-gray-500">{{ __('Khám phá các tính năng mạnh mẽ của chúng tôi') }}</p>
                                            </div>
                                        </a>
                                        <a href="#" class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white sm:h-12 sm:w-12">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">{{ __('Bảng giá') }}</p>
                                                <p class="mt-1 text-sm text-gray-500">{{ __('Lựa chọn gói phù hợp với bạn') }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Giải pháp') }}
                        </a>
                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Nhà phát triển') }}
                        </a>
                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Công ty') }}
                        </a>
                    </div>

                    <!-- Right Navigation -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-6">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Đăng nhập') }}
                        </a>
                        <a href="#" class="group inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow">
                            {{ __('Dùng thử miễn phí') }}
                            <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors"
                            :aria-expanded="mobileMenuOpen">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="lg:hidden absolute inset-x-0 transform shadow-lg bg-white border-b border-gray-200">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Sản phẩm') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Giải pháp') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Nhà phát triển') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Công ty') }}</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="space-y-1">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Đăng nhập') }}</a>
                        <a href="#" class="block px-4 py-2 text-base font-medium text-indigo-600 hover:text-indigo-700 hover:bg-gray-50">{{ __('Dùng thử miễn phí') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 via-white to-white"></div>
                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-0 left-0 -translate-x-40 -translate-y-40">
                <div class="w-[500px] h-[500px] rounded-full bg-gradient-to-br from-indigo-200/40 to-purple-200/40 blur-3xl"></div>
            </div>
            <div class="absolute bottom-0 right-0 translate-x-32 translate-y-32">
                <div class="w-[500px] h-[500px] rounded-full bg-gradient-to-br from-indigo-200/40 to-purple-200/40 blur-3xl"></div>
            </div>

            <!-- Main Hero Content -->
            <div class="relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
                    <!-- Announcement Banner -->
                    <div class="text-center mb-8">
                        <a href="#" class="inline-flex items-center gap-x-2 bg-gray-900/5 px-3 py-1 rounded-full text-sm text-gray-900 ring-1 ring-gray-900/10 hover:ring-gray-900/20 transition duration-150 ease-in-out group">
                            <span class="font-medium">{{ __('Ra mắt tính năng mới') }}</span>
                            <span class="bg-indigo-500 rounded-full px-2 py-0.5 text-xs text-white font-semibold">{{ __('Mới') }}</span>
                            <svg class="h-4 w-4 text-gray-600 group-hover:text-gray-900" viewBox="0 0 16 16" fill="none">
                                <path d="M6.75 3.25L10.75 8L6.75 12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Hero Header -->
                    <div class="text-center max-w-4xl mx-auto">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:text-7xl">
                            <span class="inline-block">{{ __('Nền tảng') }}</span>
                            <span class="inline-block text-indigo-600">{{ __('quản lý nhân sự') }}</span>
                            <span class="inline-block">{{ __('thông minh') }}</span>
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 max-w-2xl mx-auto">
                            {{ __('Giải pháp HR toàn diện giúp doanh nghiệp tự động hóa quy trình, tối ưu hiệu suất và phát triển đội ngũ. Tất cả trong một nền tảng duy nhất.') }}
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="#" class="rounded-full px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-600 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                                {{ __('Bắt đầu miễn phí') }}
                            </a>
                            <a href="#" class="flex items-center text-base font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-200">
                                {{ __('Xem demo') }}
                                <svg class="ml-2 w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Dashboard Preview -->
                    <div class="mt-16 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-full h-72 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-20 blur-3xl"></div>
                        </div>

                        <div class="relative mx-auto max-w-5xl">
                            <!-- Browser Window Frame -->
                            <div class="rounded-2xl shadow-2xl ring-1 ring-gray-900/10 overflow-hidden backdrop-blur-sm">
                                <!-- Browser Header -->
                                <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <div class="ml-4 flex-1 flex justify-center">
                                            <div class="flex items-center space-x-2 px-3 py-1 bg-gray-700/50 rounded-lg">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                <span class="text-sm text-gray-300">hr.modobom.com</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dashboard Content -->
                                <div class="bg-white">
                                    <div class="grid grid-cols-12 gap-6 p-6">
                                        <!-- Sidebar -->
                                        <div class="col-span-3 bg-gray-50 rounded-xl p-4">
                                            <div class="space-y-4">
                                                <div class="p-2 bg-white rounded-lg shadow-sm">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm font-medium text-gray-900">{{ __('Tổng quan') }}</span>
                                                    </div>
                                                </div>
                                                <div class="p-2 hover:bg-white rounded-lg transition-colors">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm font-medium text-gray-600">{{ __('Nhân viên') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Content -->
                                        <div class="col-span-9 space-y-6">
                                            <!-- Stats Row -->
                                            <div class="grid grid-cols-3 gap-6">
                                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6">
                                                    <div class="text-sm font-medium text-indigo-600">{{ __('Tổng nhân viên') }}</div>
                                                    <div class="mt-2 flex items-baseline">
                                                        <span class="text-3xl font-bold text-gray-900">2,420</span>
                                                        <span class="ml-2 text-sm text-green-500">+12</span>
                                                    </div>
                                                </div>
                                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6">
                                                    <div class="text-sm font-medium text-green-600">{{ __('Tỷ lệ hài lòng') }}</div>
                                                    <div class="mt-2 flex items-baseline">
                                                        <span class="text-3xl font-bold text-gray-900">95.8%</span>
                                                        <span class="ml-2 text-sm text-green-500">+2.4%</span>
                                                    </div>
                                                </div>
                                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6">
                                                    <div class="text-sm font-medium text-purple-600">{{ __('Hiệu suất') }}</div>
                                                    <div class="mt-2 flex items-baseline">
                                                        <span class="text-3xl font-bold text-gray-900">94.2%</span>
                                                        <span class="ml-2 text-sm text-green-500">+1.2%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Chart -->
                                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h3 class="text-base font-semibold text-gray-900">{{ __('Hoạt động tuyển dụng') }}</h3>
                                                    <div class="flex items-center space-x-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            +18.2%
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="h-48">
                                                    <div class="h-full w-full flex items-end space-x-2">
                                                        <div class="w-1/12 bg-indigo-900/10 rounded-t" style="height: 45%"></div>
                                                        <div class="w-1/12 bg-indigo-900/20 rounded-t" style="height: 65%"></div>
                                                        <div class="w-1/12 bg-indigo-900/30 rounded-t" style="height: 85%"></div>
                                                        <div class="w-1/12 bg-indigo-900/40 rounded-t" style="height: 75%"></div>
                                                        <div class="w-1/12 bg-indigo-900/50 rounded-t" style="height: 90%"></div>
                                                        <div class="w-1/12 bg-indigo-900/60 rounded-t" style="height: 100%"></div>
                                                        <div class="w-1/12 bg-indigo-900/70 rounded-t" style="height: 95%"></div>
                                                        <div class="w-1/12 bg-indigo-900/80 rounded-t" style="height: 85%"></div>
                                                        <div class="w-1/12 bg-indigo-900/90 rounded-t" style="height: 75%"></div>
                                                        <div class="w-1/12 bg-indigo-900 rounded-t" style="height: 90%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-24">
                        <p class="text-center text-sm font-semibold text-gray-500 mb-8">{{ __('ĐƯỢC TIN DÙNG BỞI CÁC DOANH NGHIỆP HÀNG ĐẦU') }}</p>
                        <div class="mx-auto grid grid-cols-4 items-center justify-items-center gap-x-8 gap-y-10 opacity-60 grayscale">
                            <img class="max-h-12 w-full object-contain" src="https://tailwindui.com/img/logos/tuple-logo-gray-900.svg" alt="Tuple">
                            <img class="max-h-12 w-full object-contain" src="https://tailwindui.com/img/logos/reform-logo-gray-900.svg" alt="Reform">
                            <img class="max-h-12 w-full object-contain" src="https://tailwindui.com/img/logos/savvycal-logo-gray-900.svg" alt="SavvyCal">
                            <img class="max-h-12 w-full object-contain" src="https://tailwindui.com/img/logos/laravel-logo-gray-900.svg" alt="Laravel">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        {{ __('Tính năng nổi bật') }}
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        {{ __('Giải pháp toàn diện cho mọi nhu cầu quản lý nhân sự của doanh nghiệp bạn') }}
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-200"></div>
                        <div class="relative p-8 bg-white rounded-2xl border border-gray-200">
                            <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('Quản lý nhân viên') }}</h3>
                            <p class="text-gray-600">{{ __('Quản lý thông tin nhân viên, hợp đồng, và tài liệu một cách hiệu quả với giao diện trực quan.') }}</p>
                            <a href="#" class="mt-6 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Tìm hiểu thêm') }}
                                <svg class="ml-2 w-4 h-4" viewBox="0 0 16 16" fill="none">
                                    <path d="M6.75 3.25L10.75 8L6.75 12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-200"></div>
                        <div class="relative p-8 bg-white rounded-2xl border border-gray-200">
                            <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('Tuyển dụng thông minh') }}</h3>
                            <p class="text-gray-600">{{ __('Tự động hóa quy trình tuyển dụng với AI, từ đăng tuyển đến sàng lọc và phỏng vấn.') }}</p>
                            <a href="#" class="mt-6 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Tìm hiểu thêm') }}
                                <svg class="ml-2 w-4 h-4" viewBox="0 0 16 16" fill="none">
                                    <path d="M6.75 3.25L10.75 8L6.75 12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-200"></div>
                        <div class="relative p-8 bg-white rounded-2xl border border-gray-200">
                            <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('Báo cáo & Phân tích') }}</h3>
                            <p class="text-gray-600">{{ __('Theo dõi và phân tích dữ liệu nhân sự với biểu đồ trực quan và báo cáo chi tiết.') }}</p>
                            <a href="#" class="mt-6 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Tìm hiểu thêm') }}
                                <svg class="ml-2 w-4 h-4" viewBox="0 0 16 16" fill="none">
                                    <path d="M6.75 3.25L10.75 8L6.75 12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-24 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">5K+</div>
                        <div class="mt-2 text-base text-gray-600">{{ __('Doanh nghiệp tin dùng') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">98%</div>
                        <div class="mt-2 text-base text-gray-600">{{ __('Khách hàng hài lòng') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">24/7</div>
                        <div class="mt-2 text-base text-gray-600">{{ __('Hỗ trợ khách hàng') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-indigo-600">50+</div>
                        <div class="mt-2 text-base text-gray-600">{{ __('Tính năng tích hợp') }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        {{ __('Khách hàng nói gì về chúng tôi') }}
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        {{ __('Khám phá trải nghiệm thực tế từ các doanh nghiệp đang sử dụng giải pháp của chúng tôi') }}
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center mb-6">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <div class="ml-4">
                                <div class="text-base font-semibold text-gray-900">Sarah Thompson</div>
                                <div class="text-sm text-gray-600">HR Director, Tech Corp</div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ __('Giải pháp HR của Modobom đã giúp chúng tôi tự động hóa 80% quy trình tuyển dụng và tiết kiệm hơn 30 giờ làm việc mỗi tuần.') }}</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center mb-6">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <div class="ml-4">
                                <div class="text-base font-semibold text-gray-900">Michael Chen</div>
                                <div class="text-sm text-gray-600">CEO, Growth Startup</div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ __('Hệ thống phân tích dữ liệu nhân sự giúp chúng tôi đưa ra quyết định chính xác và nhanh chóng hơn trong việc phát triển đội ngũ.') }}</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center mb-6">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <div class="ml-4">
                                <div class="text-base font-semibold text-gray-900">David Kim</div>
                                <div class="text-sm text-gray-600">COO, Enterprise Solutions</div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ __('Giao diện trực quan và dễ sử dụng giúp team HR của chúng tôi thích nghi nhanh chóng và làm việc hiệu quả hơn.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        {{ __('Bảng giá đơn giản và minh bạch') }}
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        {{ __('Lựa chọn gói dịch vụ phù hợp với quy mô và nhu cầu của doanh nghiệp bạn') }}
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Starter Plan -->
                    <div class="relative rounded-2xl bg-white shadow-sm">
                        <div class="p-8">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Gói Khởi Đầu') }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ __('Dành cho doanh nghiệp nhỏ') }}</p>
                            <p class="mt-4">
                                <span class="text-4xl font-bold text-gray-900">$29</span>
                                <span class="text-base text-gray-600">/tháng</span>
                            </p>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Tối đa 10 nhân viên') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Quản lý cơ bản') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Hỗ trợ email') }}</span>
                                </li>
                            </ul>
                            <a href="#" class="mt-8 block w-full py-3 px-4 rounded-lg text-center text-sm font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50 transition-colors">
                                {{ __('Bắt đầu dùng thử') }}
                            </a>
                        </div>
                    </div>

                    <!-- Professional Plan -->
                    <div class="relative rounded-2xl bg-white shadow-xl border-2 border-indigo-600">
                        <div class="absolute -top-5 left-0 right-0 flex justify-center">
                            <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-semibold bg-indigo-600 text-white">
                                {{ __('Phổ biến nhất') }}
                            </span>
                        </div>
                        <div class="p-8">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Gói Chuyên Nghiệp') }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ __('Dành cho doanh nghiệp vừa') }}</p>
                            <p class="mt-4">
                                <span class="text-4xl font-bold text-gray-900">$99</span>
                                <span class="text-base text-gray-600">/tháng</span>
                            </p>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Tối đa 50 nhân viên') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Tất cả tính năng quản lý') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Hỗ trợ 24/7') }}</span>
                                </li>
                            </ul>
                            <a href="#" class="mt-8 block w-full py-3 px-4 rounded-lg text-center text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                {{ __('Bắt đầu dùng thử') }}
                            </a>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="relative rounded-2xl bg-white shadow-sm">
                        <div class="p-8">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Gói Doanh Nghiệp') }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ __('Dành cho doanh nghiệp lớn') }}</p>
                            <p class="mt-4">
                                <span class="text-4xl font-bold text-gray-900">$299</span>
                                <span class="text-base text-gray-600">/tháng</span>
                            </p>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Không giới hạn nhân viên') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Tùy chỉnh theo yêu cầu') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ __('Hỗ trợ ưu tiên 24/7') }}</span>
                                </li>
                            </ul>
                            <a href="#" class="mt-8 block w-full py-3 px-4 rounded-lg text-center text-sm font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50 transition-colors">
                                {{ __('Liên hệ với chúng tôi') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative rounded-2xl overflow-hidden">
                    <!-- Background -->
                    <div class="absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-indigo-900 mix-blend-multiply"></div>
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2830&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply" alt="Team working">
                    </div>

                    <!-- Content -->
                    <div class="relative py-16 px-8 sm:px-16 lg:py-24 lg:px-24">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            {{ __('Sẵn sàng nâng cao hiệu quả quản lý nhân sự?') }}
                        </h2>
                        <p class="mt-4 text-lg text-indigo-100 max-w-2xl">
                            {{ __('Bắt đầu dùng thử miễn phí 14 ngày và khám phá cách Modobom có thể giúp doanh nghiệp của bạn phát triển.') }}
                        </p>
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-white hover:bg-indigo-50 transition-colors">
                                {{ __('Bắt đầu dùng thử') }}
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-900 bg-opacity-25 hover:bg-opacity-30 transition-colors">
                                {{ __('Tìm hiểu thêm') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="text-xl font-bold text-white">
                        Modobom
                    </a>
                    <p class="mt-4 text-gray-400 text-sm">
                        {{ __('Giải pháp quản lý doanh nghiệp toàn diện, giúp doanh nghiệp của bạn phát triển nhanh chóng và hiệu quả.') }}
                    </p>
                </div>

                <!-- Product Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">{{ __('Sản phẩm') }}</h3>
                    <ul class="mt-4 space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Tính năng') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Bảng giá') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Khách hàng') }}</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">{{ __('Công ty') }}</h3>
                    <ul class="mt-4 space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Về chúng tôi') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Tuyển dụng') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Blog') }}</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">{{ __('Hỗ trợ') }}</h3>
                    <ul class="mt-4 space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Trung tâm hỗ trợ') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Liên hệ') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Tài liệu API') }}</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="mt-12 pt-8 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">{{ __('Điều khoản') }}</a>
                        <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">{{ __('Chính sách bảo mật') }}</a>
                        <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">{{ __('Cookie') }}</a>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Modobom. {{ __('Đã đăng ký bản quyền.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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

