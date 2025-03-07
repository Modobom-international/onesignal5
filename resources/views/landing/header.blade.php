<header x-data="{ mobileMenuOpen: false }"
            class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm border-b border-gray-200"
            @scroll.window="$el.classList.toggle('shadow-sm', window.scrollY > 0)">
        <div class="relative">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <div class="flex lg:justify-center lg:col-start-2">
                                <img src="{{ asset('img/logo-modobom-resize-dark.png') }}" alt="Logo modobom">
                            </div>
                        </a>
                    </div>

                    <!-- Navigation Links - Desktop -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-8">
                        <!-- System Menu -->
                        <div class="nav-item relative" x-data="{ open: false }">
                            <button @mouseenter="open = true" @mouseleave="open = false"
                                class="group inline-flex items-center text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                                {{ __('Hệ thống') }}
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
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-purple-600 text-white sm:h-12 sm:w-12">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">{{ __('Bảng điều khiển') }}</p>
                                                <p class="mt-1 text-sm text-gray-500">{{ __('Theo dõi hoạt động hệ thống') }}</p>
                                            </div>
                                        </a>
                                        <a href="#" class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-purple-600 text-white sm:h-12 sm:w-12">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">{{ __('Cấu hình') }}</p>
                                                <p class="mt-1 text-sm text-gray-500">{{ __('Quản lý cài đặt hệ thống') }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Giám sát') }}
                        </a>
                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Nhật ký') }}
                        </a>
                        <a href="#" class="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Hỗ trợ') }}
                        </a>
                    </div>

                    <!-- Right Navigation -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-6">
                        <a href="{{ route('login') }}" class="group inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 shadow-sm hover:shadow">
                            {{ __('Truy cập hệ thống') }}
                            <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 transition-colors"
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
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Hệ thống') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Giám sát') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Nhật ký') }}</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Hỗ trợ') }}</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="space-y-1">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50">{{ __('Đăng nhập') }}</a>
                        <a href="#" class="block px-4 py-2 text-base font-medium text-purple-600 hover:text-purple-700 hover:bg-gray-50">{{ __('Truy cập hệ thống') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
