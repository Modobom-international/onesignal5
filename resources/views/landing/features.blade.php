<!-- Features Section -->
<div class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-base font-semibold leading-7 text-purple-600">{{ __('Giám sát hệ thống thông minh') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('Kiểm soát toàn diện hệ thống Modobom') }}</p>
            <p class="mt-6 text-lg leading-8 text-gray-600">{{ __('Hệ thống giám sát và quản lý nội bộ giúp theo dõi, phân tích và tối ưu hóa hoạt động của Modobom một cách hiệu quả.') }}</p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                <!-- Feature 1: Giám sát thời gian thực -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            {{ __('Giám sát thời gian thực') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Theo dõi hoạt động hệ thống, trạng thái domain và hiệu suất server theo thời gian thực với các chỉ số chi tiết.') }}</dd>
                    </div>
                </div>

                <!-- Feature 2: Nhật ký hoạt động -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </div>
                            {{ __('Nhật ký hoạt động') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Ghi lại và phân tích chi tiết mọi hoạt động của hệ thống, từ truy cập người dùng đến các thay đổi cấu hình quan trọng.') }}</dd>
                    </div>
                </div>

                <!-- Feature 3: Quản lý cấu hình -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                </svg>
                            </div>
                            {{ __('Quản lý cấu hình') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Điều chỉnh và tối ưu hóa cài đặt hệ thống, quản lý domain và cấu hình bảo mật một cách linh hoạt.') }}</dd>
                    </div>
                </div>

                <!-- Feature 4: Quản lý người dùng -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            {{ __('Quản lý người dùng') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Theo dõi và quản lý quyền truy cập của người dùng, phân quyền chi tiết và giám sát hoạt động.') }}</dd>
                    </div>
                </div>

                <!-- Feature 5: Thống kê & Báo cáo -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            {{ __('Thống kê & Báo cáo') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Tạo báo cáo chi tiết về hiệu suất hệ thống, lưu lượng truy cập và các số liệu quan trọng khác.') }}</dd>
                    </div>
                </div>

                <!-- Feature 6: Cảnh báo & Thông báo -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 p-10">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </div>
                            {{ __('Cảnh báo & Thông báo') }}
                        </dt>
                        <dd class="mt-4 text-base leading-7 text-gray-600">{{ __('Nhận thông báo tức thì về các sự cố, cảnh báo bảo mật và các thay đổi quan trọng trong hệ thống.') }}</dd>
                    </div>
                </div>
            </dl>
        </div>
    </div>
</div>
