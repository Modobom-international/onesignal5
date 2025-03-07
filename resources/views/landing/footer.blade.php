<footer class="bg-gray-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- System Info -->
            <div class="col-span-1 md:col-span-2">
                <a href="/" class="text-xl font-bold text-white">

                        <img src="{{ asset('img/logo-modobom-resize.png') }}" alt="Logo modobom">

                </a>
                <p class="mt-4 text-gray-400 text-sm">
                    {{ __('Hệ thống quản lý và giám sát nội bộ Modobom, cung cấp các công cụ theo dõi, phân tích và tối ưu hóa hoạt động.') }}
                </p>
            </div>

            <!-- System Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">{{ __('Hệ thống') }}</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Bảng điều khiển') }}</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Cấu hình') }}</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Giám sát') }}</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">{{ __('Hỗ trợ') }}</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Tài liệu') }}</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Hướng dẫn') }}</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">{{ __('Liên hệ') }}</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="mt-12 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">{{ __('Điều khoản nội bộ') }}</a>
                    <a href="#" class="text-gray-400 hover:text-gray-300 text-sm">{{ __('Chính sách bảo mật') }}</a>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Modobom</p>
                </div>
            </div>
        </div>
    </div>
</footer>
