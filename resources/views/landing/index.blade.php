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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <!-- Header/Navigation -->
    <header x-data="{ mobileMenuOpen: false }" class="absolute inset-x-0 top-0 z-50">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">MODOBOM</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" @click="mobileMenuOpen = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">{{ __('Mở menu') }}</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#features" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition-colors">{{ __('Tính năng') }}</a>
                <a href="#testimonials" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition-colors">{{ __('Khách hàng') }}</a>
                <a href="#pricing" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition-colors">{{ __('Bảng giá') }}</a>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition-colors">{{ __('Về chúng tôi') }}</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-6">
                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition-colors">{{ __('Đăng nhập') }}</a>
                <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Dùng thử miễn phí') }}
                </a>
            </div>
        </nav>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" class="lg:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">MODOBOM</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                    </a>
                    <button type="button" @click="mobileMenuOpen = false" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">{{ __('Đóng menu') }}</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#features" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Tính năng') }}</a>
                            <a href="#testimonials" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Khách hàng') }}</a>
                            <a href="#pricing" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Bảng giá') }}</a>
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Về chúng tôi') }}</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Đăng nhập') }}</a>
                            <a href="{{ route('register') }}" class="mt-4 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ __('Dùng thử miễn phí') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <div class="relative pt-14">
            @include('landing.components.hero')
        </div>

        <!-- Features Section -->
        <div id="features">
            @include('landing.components.features')
        </div>

        <!-- Dashboard Preview Section -->
        <div>
            @include('landing.components.dashboard-preview')
        </div>

        <!-- Testimonials Section -->
        <div id="testimonials">
            @include('landing.components.testimonials')
        </div>

        <!-- Pricing Section -->
        <div id="pricing">
            @include('landing.components.pricing')
        </div>

        <!-- CTA Section -->
        <div>
            @include('landing.components.cta')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8">
                    <img class="h-7" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="MODOBOM">
                    <p class="text-sm leading-6 text-gray-300">{{ __('Giải pháp quản lý nhân sự toàn diện cho doanh nghiệp của bạn.') }}</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Giải pháp') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Quản lý nhân viên') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Chấm công') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Đánh giá KPI') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Tuyển dụng') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Hỗ trợ') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Trung tâm trợ giúp') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Tài liệu API') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Hướng dẫn sử dụng') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Liên hệ') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Công ty') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Về chúng tôi') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Blog') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Đối tác') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Tuyển dụng') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Pháp lý') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Chính sách bảo mật') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Điều khoản sử dụng') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Chính sách cookie') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
                <p class="text-xs leading-5 text-gray-400">&copy; {{ date('Y') }} MODOBOM. {{ __('Đã đăng ký bản quyền.') }}</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
