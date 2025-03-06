<!-- Pricing Section -->
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">{{ __('Bảng giá') }}</h2>
            <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ __('Lựa chọn gói phù hợp với doanh nghiệp của bạn') }}</p>
        </div>
        <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">{{ __('Giải pháp linh hoạt cho mọi quy mô doanh nghiệp, từ startup đến tập đoàn lớn.') }}</p>

        <div class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <!-- Starter Plan -->
            <div class="group relative rounded-3xl p-8 ring-1 ring-gray-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-starter" class="text-lg font-semibold leading-8 text-indigo-600">{{ __('Starter') }}</h3>
                    <p class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold leading-5 text-indigo-600">{{ __('Phổ biến') }}</p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('Giải pháp tối ưu cho doanh nghiệp vừa và nhỏ') }}</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span class="text-4xl font-bold tracking-tight text-gray-900">2.000.000</span>
                    <span class="text-sm font-semibold leading-6 text-gray-600">VNĐ/tháng</span>
                </p>
                <a href="#" aria-describedby="tier-starter" class="mt-6 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Dùng thử miễn phí') }}
                </a>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tối đa 50 nhân viên') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Quản lý thông tin nhân viên') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Chấm công cơ bản') }}
                    </li>
                </ul>
            </div>

            <!-- Professional Plan -->
            <div class="group relative rounded-3xl p-8 bg-white ring-2 ring-indigo-600 transition-all duration-300 hover:scale-105 hover:shadow-xl lg:-mx-4 lg:flex lg:flex-col">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-professional" class="text-lg font-semibold leading-8 text-indigo-600">{{ __('Professional') }}</h3>
                    <p class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold leading-5 text-indigo-600">{{ __('Khuyến nghị') }}</p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('Giải pháp toàn diện cho doanh nghiệp đang phát triển') }}</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span class="text-4xl font-bold tracking-tight text-gray-900">5.000.000</span>
                    <span class="text-sm font-semibold leading-6 text-gray-600">VNĐ/tháng</span>
                </p>
                <a href="#" aria-describedby="tier-professional" class="mt-6 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Bắt đầu dùng thử') }}
                </a>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tối đa 200 nhân viên') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tất cả tính năng của gói Starter') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Quản lý KPI và đánh giá') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Báo cáo nâng cao') }}
                    </li>
                </ul>
            </div>

            <!-- Enterprise Plan -->
            <div class="group relative rounded-3xl p-8 ring-1 ring-gray-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-enterprise" class="text-lg font-semibold leading-8 text-indigo-600">{{ __('Enterprise') }}</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('Giải pháp tùy chỉnh cho doanh nghiệp lớn') }}</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                    <span class="text-4xl font-bold tracking-tight text-gray-900">{{ __('Liên hệ') }}</span>
                </p>
                <a href="#" aria-describedby="tier-enterprise" class="mt-6 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('Liên hệ với chúng tôi') }}
                </a>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Không giới hạn số lượng nhân viên') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tất cả tính năng của gói Professional') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tùy chỉnh theo yêu cầu') }}
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Hỗ trợ 24/7 ưu tiên') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
