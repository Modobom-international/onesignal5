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

            @include('landing.components.dashboard-preview')

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
