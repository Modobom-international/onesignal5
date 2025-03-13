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

        <!-- Back to top button -->
        <button onclick="topFunction()" id="back-to-top"
            class="fixed bottom-8 z-50 right-8 bg-indigo-600 text-white rounded-full p-3 shadow-lg hover:bg-indigo-700 transition-all duration-200 hover:shadow-xl hover:-translate-y-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>

        <!-- Statistics Section -->
        <div class="mt-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/80  transition-all duration-200 group">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">{{ __('Tổng id') }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-indigo-600 group-hover:text-indigo-500 transition-colors duration-200">
                            @if ($statusPaginate)
                            {{ $data->total() }}
                            @else
                            {{ count($data) }}
                            @endif
                        </dd>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/80  transition-all duration-200 group">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">{{ __('Tổng lượt cài') }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-indigo-600 group-hover:text-indigo-500 transition-colors duration-200">
                            {{ $totalInstall ?? 0 }}
                        </dd>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/80  transition-all duration-200 group">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">{{ __('Tổng sai quốc gia') }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-indigo-600 group-hover:text-indigo-500 transition-colors duration-200">
                            {{ $totalWrongCountry ?? 0 }}
                        </dd>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200/80  transition-all duration-200 group">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">{{ __('Tổng sai nhà mạng') }}</dt>
                        <dd class="mt-2 text-3xl font-semibold text-indigo-600 group-hover:text-indigo-500 transition-colors duration-200">
                            {{ $totalWrongNetWork ?? 0 }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>



        <!-- Date Comparison Modal -->
        <div id="modalDateComparison" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ __('So sánh dữ liệu') }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="modalDateComparison">
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
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Current Date Section -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-sm font-medium text-gray-700">{{ __('Ngày hiện tại') }}</h5>
                                    <span id="current-date-display" class="text-sm text-gray-500"></span>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dl class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Tổng lượt cài') }}</dt>
                                            <dd id="current-total-installs" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Thành công') }}</dt>
                                            <dd id="current-success-installs" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Sai quốc gia') }}</dt>
                                            <dd id="current-wrong-country" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Sai mạng') }}</dt>
                                            <dd id="current-wrong-network" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Comparison Date Section -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-sm font-medium text-gray-700">{{ __('Ngày so sánh') }}</h5>
                                    <div class="relative">
                                        <input type="text" id="comparison-date"
                                            class="block w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="{{ __('Chọn ngày') }}">
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dl class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Tổng lượt cài') }}</dt>
                                            <dd id="comparison-total-installs" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Thành công') }}</dt>
                                            <dd id="comparison-success-installs" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Sai quốc gia') }}</dt>
                                            <dd id="comparison-wrong-country" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs text-gray-500">{{ __('Sai mạng') }}</dt>
                                            <dd id="comparison-wrong-network" class="mt-1 text-lg font-semibold text-gray-900">-</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Comparison Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <div id="comparison-loader" class="hidden">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-indigo-600"></div>
                            </div>
                            <button type="button" id="compare-dates"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                {{ __('So sánh') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="mt-4">
            @if (count($data) > 0)
            <x-table>
                <x-table.header class="border-t border-gray-200">
                    <x-table.row>
                        <x-table.head>ID</x-table.head>
                        <x-table.head>{{ __('Ứng dụng') }}</x-table.head>
                        <x-table.head>{{ __('Quốc gia') }}</x-table.head>
                        <x-table.head>{{ __('Nền tảng') }}</x-table.head>
                        <x-table.head>{{ __('Nhà mạng') }}</x-table.head>
                        <x-table.head>{{ __('Time UTC') }}</x-table.head>
                        <x-table.head>{{ __('Ngày tạo') }}</x-table.head>
                        <x-table.head>{{ __('Hành vi') }}</x-table.head>
                    </x-table.row>
                </x-table.header>

                <x-table.body>
                    @foreach ($data as $item)
                    <x-table.row class="hover:bg-gray-50">
                        <x-table.cell class="font-mono text-xs">{{ $item->uid ?? 'N/A' }}</x-table.cell>
                        <x-table.cell class="text-sm font-mono text-gray-900">
                            {{ $item->app ?? 'N/A' }}
                        </x-table.cell>
                        <x-table.cell class="text-sm font-mono text-gray-900">
                            {{ $item->country ?? 'N/A' }}
                        </x-table.cell>
                        <x-table.cell>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-mono bg-gray-100 text-gray-800">
                                {{ $item->platform ?? 'N/A' }}
                            </span>
                        </x-table.cell>
                        <x-table.cell class="text-sm font-mono text-gray-900">
                            {{ $item->network ?: 'KHONG_CO_SIM' }}
                        </x-table.cell>
                        <x-table.cell class="font-mono text-xs">{{ $item->timeutc ?? 'N/A' }}</x-table.cell>
                        <x-table.cell>
                            @php
                            $date = $item->date ?? null;
                            if ($date instanceof \MongoDB\BSON\UTCDateTime) {
                            $formattedDate = $date->toDateTime()->format('Y-m-d H:i:s');
                            } elseif ($date && is_string($date)) {
                            $formattedDate = date('Y-m-d H:i:s', strtotime($date));
                            } else {
                            $formattedDate = 'N/A';
                            }
                            @endphp
                            <span class="font-mono text-xs">{{ $formattedDate }}</span>
                        </x-table.cell>
                        <x-table.cell class="max-w-md whitespace-normal">
                            @php
                            $behavior = $item->behavior ?? '';
                            if (is_string($behavior)) {
                            $behaviorData = json_decode($behavior, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($behaviorData)) {
                            echo '<div class="space-y-1.5">';
                                foreach ($behaviorData as $key => $value) {
                                $bgColor = 'bg-gray-50';
                                $textColor = 'text-gray-600';

                                if (strpos($key, 'INSTALL') !== false) {
                                $bgColor = 'bg-emerald-50';
                                $textColor = 'text-emerald-700';
                                } elseif (strpos($value, 'SUCCESS') !== false || strpos($key, 'SUB_OK') !== false) {
                                $bgColor = 'bg-blue-50';
                                $textColor = 'text-blue-700';
                                } elseif (strpos($key, 'ERRO') !== false || strpos($value, 'ERRO') !== false || strpos($key, 'SAI_') !== false) {
                                $bgColor = 'bg-red-50';
                                $textColor = 'text-red-700';
                                } elseif (strpos($key, 'PERMISSION') !== false) {
                                $bgColor = 'bg-amber-50';
                                $textColor = 'text-amber-700';
                                }

                                echo "<div class='text-xs p-1.5 rounded {$bgColor} break-words'>";
                                    echo "<span class='font-medium {$textColor}'>{$key}:</span> ";

                                    if (strpos($value, 'DEVICE:') !== false) {
                                    $parts = explode('DEVICE:', $value);
                                    echo "<span class='break-all'>" . e(trim($parts[0])) . "</span>";
                                    if (isset($parts[1])) {
                                    echo "<div class='mt-1 font-mono text-xs text-gray-500 break-all'>DEVICE: " . e(trim($parts[1])) . "</div>";
                                    }
                                    } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
                                    echo "<span class='break-all text-blue-600 hover:text-blue-800'>" . e($value) . "</span>";
                                    } else {
                                    echo "<span class='break-all'>" . e($value) . "</span>";
                                    }

                                    echo "</div>";
                                }
                                echo '</div>';
                            } else {
                            echo '<div class="text-xs text-gray-600 break-words">' . e($behavior) . '</div>';
                            }
                            } else {
                            echo '<span class="text-gray-400">N/A</span>';
                            }
                            @endphp
                        </x-table.cell>
                    </x-table.row>
                    @endforeach
                </x-table.body>
            </x-table>
            @else
            <div class="bg-white px-6 py-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-lg bg-gray-50">
                        <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z" />
                            <path fill-rule="evenodd"
                                d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('Không tìm thấy dữ liệu') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('Bạn có thể thay đổi bộ lọc hoặc tìm kiếm lại để mở rộng kết quả.') }}
                    </p>
                </div>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if (count($data) > 0 && $statusPaginate)
        <div class="mt-6">
            {{ $data->appends(request()->except('page'))->links() }}
        </div>
        @endif
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