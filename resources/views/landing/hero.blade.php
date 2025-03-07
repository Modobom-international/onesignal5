<!-- Hero Section -->
<div class="relative overflow-hidden bg-white">
    <!-- Background decoration -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-50 to-indigo-50 opacity-50"></div>
        <div class="absolute right-0 top-0 -mt-16 opacity-20">
            <svg width="404" height="384" fill="none" viewBox="0 0 404 384">
                <defs>
                    <pattern id="pattern-squares" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="384" fill="url(#pattern-squares)" />
            </svg>
        </div>
    </div>

    <div class="relative mx-auto ">
        <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
            <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
                <!-- Left Content -->
                <div class="lg:col-span-6 lg:flex lg:flex-col lg:justify-center">
                    <div class="max-w-xl space-y-8" x-data="{ hover: false }">
                        <div class="space-y-4">
                            <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800">
                                {{ __('Hệ thống nội bộ') }}
                            </span>
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block mb-2">{{ __('Quản lý & Giám sát') }}</span>
                                <span class="block bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text h-20 text-transparent">{{ __('Hệ thống Modobom') }}</span>
                            </h1>
                        </div>

                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            {{ __('Theo dõi, quản lý và tối ưu hóa hoạt động của hệ thống Modobom. Giám sát người dùng, phân tích hành vi và đảm bảo an toàn dữ liệu.') }}
                        </p>

                        <!-- Feature List -->
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-base text-gray-600">{{ __('Theo dõi hoạt động người dùng theo thời gian thực') }}</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-base text-gray-600">{{ __('Giám sát và quản lý tên miền hệ thống') }}</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-base text-gray-600">{{ __('Phân tích và ghi nhật ký hệ thống chi tiết') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-x-6">
                            <a href="#"
                               @mouseenter="hover = true"
                               @mouseleave="hover = false"
                               class="relative inline-flex items-center rounded-lg bg-purple-600 px-8 py-3 text-base font-semibold text-white transition-all duration-300 hover:bg-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                                {{ __('Truy cập hệ thống') }}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="ml-2 h-5 w-5 transition-transform duration-300"
                                     :class="{ 'translate-x-1': hover }"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>

                        </div>

                        <!-- System Info -->
                        <div class="pt-8 border-t border-gray-200">
                            <p class="text-sm font-semibold text-gray-400 uppercase tracking-wide">{{ __('Thông tin hệ thống') }}</p>
                            <div class="mt-4 grid grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">24/7</div>
                                    <div class="text-sm text-gray-500">{{ __('Giám sát') }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">99.9%</div>
                                    <div class="text-sm text-gray-500">{{ __('Uptime') }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">< 1s</div>
                                    <div class="text-sm text-gray-500">{{ __('Phản hồi') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Showcase -->
                <div class="mt-16 lg:mt-0 lg:col-span-6" x-data="{ activeTab: 'dashboard' }">
                    <div class="relative">
                        <!-- Background Glow Effect -->
                        <div class="absolute -inset-x-4 -top-12 -bottom-16 overflow-hidden">
                            <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-purple-100 opacity-20"></div>
                        </div>

                        <!-- Showcase Window -->
                        <div class="relative rounded-2xl bg-white shadow-xl ring-1 ring-slate-900/5">
                            <!-- Window Header -->
                            <div class="relative rounded-t-2xl bg-slate-800 p-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                                        <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
                                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                                    </div>
                                    <div class="text-xs text-slate-400">modobom-system-monitor</div>
                                </div>
                            </div>

                            <!-- Showcase Content -->
                            <div class="relative rounded-b-2xl bg-slate-50 p-4">
                                <!-- Navigation Tabs -->
                                <div class="mb-4 flex space-x-4 border-b border-slate-200">
                                    <button @click="activeTab = 'dashboard'"
                                            :class="{ 'border-purple-500 text-purple-600': activeTab === 'dashboard', 'border-transparent text-slate-500': activeTab !== 'dashboard' }"
                                            class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                                        {{ __('Bảng điều khiển') }}
                                    </button>
                                    <button @click="activeTab = 'tracking'"
                                            :class="{ 'border-purple-500 text-purple-600': activeTab === 'tracking', 'border-transparent text-slate-500': activeTab !== 'tracking' }"
                                            class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                                        {{ __('Theo dõi') }}
                                    </button>
                                    <button @click="activeTab = 'logs'"
                                            :class="{ 'border-purple-500 text-purple-600': activeTab === 'logs', 'border-transparent text-slate-500': activeTab !== 'logs' }"
                                            class="border-b-2 px-4 py-2 text-sm font-medium transition-colors">
                                        {{ __('Nhật ký') }}
                                    </button>
                                </div>

                                <!-- Dashboard View -->
                                <div x-show="activeTab === 'dashboard'" class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                                            <div class="text-sm font-medium text-slate-500">{{ __('Truy cập hôm nay') }}</div>
                                            <div class="mt-2 text-2xl font-semibold text-slate-900">1,234</div>
                                            <div class="mt-1 text-sm text-green-500">+8% so với hôm qua</div>
                                        </div>
                                        <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                                            <div class="text-sm font-medium text-slate-500">{{ __('Tổng domain') }}</div>
                                            <div class="mt-2 text-2xl font-semibold text-slate-900">45</div>
                                            <div class="mt-1 text-sm text-green-500">100% hoạt động</div>
                                        </div>
                                    </div>

                                    <!-- System Status -->
                                    <div class="mt-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                                        <div class="mb-4 flex items-center justify-between">
                                            <h3 class="text-sm font-medium text-slate-900">{{ __('Trạng thái hệ thống') }}</h3>
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                {{ __('Tất cả hoạt động tốt') }}
                                            </span>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between py-2">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-slate-900">{{ __('Hệ thống chính') }}</div>
                                                        <div class="text-xs text-slate-500">{{ __('Hoạt động bình thường') }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-block h-2 w-2 rounded-full bg-green-400"></span>
                                                    <span class="text-sm text-slate-500">100%</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between py-2 border-t">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-slate-900">{{ __('Mạng nội bộ') }}</div>
                                                        <div class="text-xs text-slate-500">{{ __('45 domain hoạt động') }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-block h-2 w-2 rounded-full bg-green-400"></span>
                                                    <span class="text-sm text-slate-500">100%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tracking View -->
                                <div x-show="activeTab === 'tracking'" class="space-y-4">
                                    <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                                        <div class="mb-4 flex items-center justify-between">
                                            <h3 class="text-sm font-medium text-slate-900">{{ __('Hoạt động gần đây') }}</h3>
                                            <button class="text-sm text-purple-600 hover:text-purple-500">{{ __('Xem tất cả') }}</button>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                                        <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-slate-900">{{ __('Admin') }}</div>
                                                        <div class="text-xs text-slate-500">{{ __('Cập nhật cấu hình hệ thống') }}</div>
                                                    </div>
                                                </div>
                                                <span class="text-xs text-slate-400">{{ __('Vừa xong') }}</span>
                                            </div>
                                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                                        <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-slate-900">{{ __('System') }}</div>
                                                        <div class="text-xs text-slate-500">{{ __('Tự động sao lưu dữ liệu') }}</div>
                                                    </div>
                                                </div>
                                                <span class="text-xs text-slate-400">5 phút trước</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logs View -->
                                <div x-show="activeTab === 'logs'" class="space-y-4">
                                    <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                                        <div class="mb-4 flex items-center justify-between">
                                            <h3 class="text-sm font-medium text-slate-900">{{ __('Nhật ký hệ thống') }}</h3>
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-block h-2 w-2 rounded-full bg-green-400 animate-pulse"></span>
                                                <span class="text-xs text-slate-500">{{ __('Đang ghi') }}</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2 font-mono text-xs">
                                            <div class="p-2 bg-slate-50 rounded">
                                                <span class="text-slate-400">[12:45:30]</span>
                                                <span class="text-green-600">INFO</span>
                                                <span class="text-slate-700">{{ __('Cập nhật cấu hình thành công') }}</span>
                                            </div>
                                            <div class="p-2 bg-slate-50 rounded">
                                                <span class="text-slate-400">[12:45:28]</span>
                                                <span class="text-purple-600">DEBUG</span>
                                                <span class="text-slate-700">{{ __('Kiểm tra kết nối domain modobom.com') }}</span>
                                            </div>
                                            <div class="p-2 bg-slate-50 rounded">
                                                <span class="text-slate-400">[12:45:25]</span>
                                                <span class="text-yellow-600">WARN</span>
                                                <span class="text-slate-700">{{ __('Phát hiện truy cập không hợp lệ') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
