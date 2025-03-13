@extends('layouts.app')

@section('title', 'Log behavior')

@section('content')
<div class="py-8">
    <div class="">
        <!-- Page Header -->
        <div class="border-border border-b pb-6">
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Hành vi người dùng') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Xem và quản lý hành vi người dùng từ các ứng dụng') }}</p>
        </div>

        
    </div>
</div>

<!-- Change Selection Modal -->
<div id="modalChangeSelection" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalChangeSelectionLabel">
                    {{ __('Chỉnh sửa lựa chọn') }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modalChangeSelection">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <!-- Your existing modal content -->
                <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                    <!-- Keep your existing content structure -->
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <!-- Countries -->
                        <div class="bg-white rounded-lg border border-gray-200/80 overflow-hidden">
                            <div class="border-b border-gray-200/80 bg-gray-50/80 px-4 py-3">
                                <h4 class="text-base font-medium text-gray-900">{{ __('Quốc gia') }}</h4>
                            </div>
                            <div class="p-4">
                                <div class="max-h-96 overflow-y-auto">
                                    <ul class="space-y-2">
                                        @foreach ($countries as $country)
                                        @if ($country != null)
                                        <li class="flex items-center">
                                            @if (in_array($country, $listDefaultCountry))
                                            <input type="checkbox"
                                                class="check-box-country h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                data-id="{{ $country }}" checked disabled>
                                            @else
                                            <input type="checkbox"
                                                class="check-box-country h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                data-id="{{ $country }}"
                                                {{ in_array($country, $listArrayCountry) ? 'checked' : '' }}>
                                            @endif
                                            <label
                                                class="ml-2 text-sm text-gray-700">{{ $country }}</label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Platforms -->
                        <div class="bg-white rounded-lg border border-gray-200/80 overflow-hidden">
                            <div class="border-b border-gray-200/80 bg-gray-50/80 px-4 py-3">
                                <h4 class="text-base font-medium text-gray-900">{{ __('Nền tảng') }}</h4>
                            </div>
                            <div class="p-4">
                                <div class="max-h-96 overflow-y-auto">
                                    <ul class="space-y-2">
                                        @foreach ($platforms as $platform)
                                        @if ($platform != null)
                                        <li class="flex items-center">
                                            @if (in_array($platform, $listDefaultPlatform))
                                            <input type="checkbox"
                                                class="check-box-platform h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                data-id="{{ $platform }}" checked disabled>
                                            @else
                                            <input type="checkbox"
                                                class="check-box-platform h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                data-id="{{ $platform }}"
                                                {{ in_array($platform, $listArrayPlatform) ? 'checked' : '' }}>
                                            @endif
                                            <label
                                                class="ml-2 text-sm text-gray-700">{{ $platform }}</label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Apps -->
                        <div class="bg-white rounded-lg border border-gray-200/80 overflow-hidden">
                            <div class="border-b border-gray-200/80 bg-gray-50/80 px-4 py-3">
                                <h4 class="text-base font-medium text-gray-900">{{ __('Ứng dụng') }}</h4>
                            </div>
                            <div class="p-4">
                                <div class="relative">
                                    <input type="text" id="search-in-filter-modal"
                                        placeholder="{{ __('Nhập tên ứng dụng') }}"
                                        class="block w-full rounded-lg border border-gray-300 bg-white pl-4 pr-10 py-2.5 text-sm text-gray-900 placeholder-gray-500 shadow-sm transition-all duration-200 hover:border-indigo-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                                        onkeypress="search()" onkeydown="search()">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 max-h-96 overflow-y-auto">
                                    <ul class="space-y-2" id="ul-list-app-in-modal">
                                        @foreach ($apps as $app)
                                        @if ($app != null)
                                        <li class="flex items-center">
                                            <input type="checkbox"
                                                class="check-box-app h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                data-id="{{ $app }}"
                                                {{ in_array($app, $listArrayApp) ? 'checked' : '' }}>
                                            <label
                                                class="ml-2 text-sm text-gray-700">{{ $app }}</label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="button" id="save-change-option"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Lưu') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div id="modalReport" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalReportLabel">
                    {{ __('Thống kê') }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modalReport">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <!-- Your existing modal content -->
                <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                    <!-- Keep your existing content structure -->
                    <div class="mt-6 bg-white rounded-lg border border-gray-200/80 overflow-hidden">
                        <div class="border-b border-gray-200/80 bg-gray-50/80 px-6 py-4">
                            <h4 class="text-base font-medium text-gray-900">{{ __('Bộ lọc') }}</h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Từ ngày') }}</label>
                                    <div class="relative group">
                                        <input type="text" id="datepicker-from"
                                            class="block w-full appearance-none rounded-lg border border-gray-300 bg-white pl-4 pr-12 py-2.5 text-sm text-gray-900 placeholder-gray-500 shadow-sm transition-all duration-200 hover:border-indigo-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 group-hover:shadow-md"
                                            placeholder="{{ __('Chọn ngày bắt đầu') }}">

                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Đến ngày') }}</label>
                                    <div class="relative group">
                                        <input type="text" id="datepicker-to"
                                            class="block w-full appearance-none rounded-lg border border-gray-300 bg-white pl-4 pr-12 py-2.5 text-sm text-gray-900 placeholder-gray-500 shadow-sm transition-all duration-200 hover:border-indigo-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 group-hover:shadow-md"
                                            placeholder="{{ __('Chọn ngày kết thúc') }}">

                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Quốc gia') }}</label>
                                    <div class="relative group">
                                        <select id="country-report"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="all">{{ __('Tất cả') }}</option>
                                            @foreach ($listArrayCountry as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Nền tảng') }}</label>
                                    <div class="relative group">
                                        <select id="platform-report"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="all">{{ __('Tất cả') }}</option>
                                            @foreach ($listArrayPlatform as $platform)
                                            <option value="{{ $platform }}">{{ $platform }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Ứng dụng') }}</label>
                                    <div class="relative group">
                                        <select id="app-name-report"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="all">{{ __('Tất cả') }}</option>
                                            @foreach ($listArrayApp as $app)
                                            <option value="{{ $app }}">{{ $app }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700">{{ __('Từ khóa') }}</label>
                                    <div class="relative group">
                                        <select id="keyword-report"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="all">{{ __('Tất cả') }}</option>
                                            @foreach ($keywords as $keyword)
                                            <option value="{{ $keyword }}">{{ $keyword }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="button" onclick="getDataChart()"
                                    class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    {{ __('Thống kê') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Results -->
                    <div class="mt-8">
                        <div id="pre-loader" class="flex justify-center">
                            @include('components.pre-loader')
                        </div>
                        <div id="text-total-modal" class="hidden justify-center space-x-8 mt-6 mb-8">
                            <div class="text-center">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Tổng lượt cài') }}</dt>
                                <dd class="mt-1 text-3xl font-semibold text-indigo-600" id="sum-total"></dd>
                            </div>
                            <div class="text-center">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Tổng thành công') }}</dt>
                                <dd class="mt-1 text-3xl font-semibold text-indigo-600" id="sum-success"></dd>
                            </div>
                        </div>
                        <div class="chart-container bg-white rounded-lg border border-gray-200/80 p-6">
                            <canvas id="countChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Modal -->
<div id="modalActivity" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalActivityLabel">
                    {{ __('Lịch sử hoạt động') }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modalActivity">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Đóng') }}</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <!-- Your existing modal content -->
                <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                    <!-- Keep your existing content structure -->
                    <div class="mt-6 bg-white rounded-lg border border-gray-200/80 overflow-hidden">
                        <div class="border-b border-gray-200/80 bg-gray-50/80 px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <input type="text" id="uid-activity"
                                        placeholder="{{ __('Nhập id device') }}"
                                        class="block w-full appearance-none rounded-lg border border-gray-300 bg-white pl-4 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-500 shadow-sm transition-all duration-200 hover:border-indigo-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                </div>
                                <button type="button" onclick="searchActivity()"
                                    class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ __('Tìm kiếm') }}
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200/80">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Thời gian') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Hoạt động') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Dữ liệu (nếu có)') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200/80 bg-white" id="table-activity"></tbody>
                            </table>
                        </div>

                        <div id="pre-loader-activity" class="flex justify-center p-6">
                            @include('components.pre-loader')
                        </div>

                        <div id="empty-result" class="hidden p-6 text-center">
                            <p class="text-sm font-medium text-red-600">{{ __('Không tìm thấy kết quả') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var backToTop = document.getElementById("back-to-top");
    var chart = 'chart';
    var app = '<?php echo $filter['app']; ?>';
    var country = '<?php echo $filter['country']; ?>';
    var platform = '<?php echo $filter['platform']; ?>';
    var network = '<?php echo $filter['network']; ?>';
    var install = '<?php echo $filter['install']; ?>';
    var date = '<?php echo $filter['date']; ?>';
    var today = '<?php echo $today; ?>';
    var prevToday = '<?php echo $prevToday; ?>';
    var urlParams = new URLSearchParams(window.location.search);
    var strInPage = '';
    var statusNowDate = true;
    if (install) {
        $("#install").val(install);
        if (strInPage == '') {
            strInPage += '?install=' + install;
        } else {
            strInPage += '&install=' + install;
        }
    }
</script>
<script src="{{ asset('js/log-behavior.js') }}"></script>
@endsection