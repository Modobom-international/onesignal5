@extends('layouts.app')

@section('title', 'Log HTML Source')

@section('content')
    <div class="py-8">
        <div>
            <div class="rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Nguồn HTML') }}</h2>
                </div>

                <div class="p-6">
                    <!-- Filters Section -->
                    <div class="space-y-6">

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
                            <!-- Date Filter -->
                            <div class="space-y-1">
                                <label for="datepicker"
                                    class="block text-sm font-medium text-gray-700">{{ __('Ngày') }}</label>
                                <input type="text" id="datepicker" readonly
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-pointer bg-white">
                            </div>

                            <!-- App Filter -->
                            <div class="space-y-1">
                                <label for="app-name"
                                    class="block text-sm font-medium text-gray-700">{{ __('Ứng dụng') }}</label>
                                <select id="app-name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="all">{{ __('Tất cả') }}</option>
                                    @foreach ($apps as $appItem)
                                        @if ($appItem->app_id != '')
                                            <option @if ($app == $appItem->app_id) selected @endif
                                                value="{{ $appItem->app_id }}">{{ $appItem->app_id }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Country Filter -->
                            <div class="space-y-1">
                                <label for="country-name"
                                    class="block text-sm font-medium text-gray-700">{{ __('Quốc gia') }}</label>
                                <select id="country-name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="all">{{ __('Tất cả') }}</option>
                                    @foreach ($countries as $countryItem)
                                        @if ($countryItem->country != '')
                                            <option @if ($country == $countryItem->country) selected @endif
                                                value="{{ $countryItem->country }}">{{ $countryItem->country }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Device Filter -->
                            <div class="space-y-1">
                                <label for="text-device"
                                    class="block text-sm font-medium text-gray-700">{{ __('Thiết bị') }}</label>
                                <input type="text" id="text-device" value="{{ $device }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- Source Filter -->
                            <div class="space-y-1">
                                <label for="text-source"
                                    class="block text-sm font-medium text-gray-700">{{ __('Từ khóa nguồn') }}</label>
                                <input type="text" id="text-source" value="{{ $textSource }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="flex justify-end">
                            <button type="button" id="search-report"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Tìm kiếm') }}
                            </button>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="mt-6">
                        <p class="text-sm text-gray-700">
                            {{ __('Tổng') }}: <span class="font-medium text-indigo-600">{{ $count }}</span>
                        </p>
                    </div>

                    <!-- Results Table -->
                    <div class="mt-4 flex flex-col">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                                    ID</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Đường dẫn') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Quốc gia') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Nền tảng') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Thiết bị') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Nguồn') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('ID ứng dụng') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Phiên bản') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Ngày tạo') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Ghi chú') }}</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">{{ __('Hành động') }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @if (count($dataPaginate) > 0)
                                                @foreach ($dataPaginate as $source)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900">
                                                            {{ $source->id }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ Str::limit($source->url, 100) }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->country ?? '' }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->platform ?? '' }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->device_id ?? '' }}</td>
                                                        <td class="px-3 py-4 text-sm text-gray-500">
                                                            <div class="flex items-center space-x-2">
                                                                <button data-type="email"
                                                                    class="text-indigo-600 hover:text-indigo-900">{{ Str::limit($source->source, 100) }}</button>
                                                                @if ($source->source != null)
                                                                    <button data-type="copy"
                                                                        class="text-gray-400 hover:text-gray-600">
                                                                        <svg class="h-4 w-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->app_id }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->version }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->created_at }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {{ $source->note }}</td>
                                                        <td
                                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <button
                                                                data-url="{{ route('html.source.show', $source->id) }}"
                                                                class="text-indigo-600 hover:text-indigo-900 details-btn">
                                                                {{ __('Chi tiết') }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="11" class="px-3 py-8 text-center">
                                                        <div class="flex flex-col items-center justify-center">
                                                            <svg class="h-12 w-12 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1"
                                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                            </svg>
                                                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                                                {{ __('Không có dữ liệu') }}</h3>
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                {{ __('Không tìm thấy bản ghi nào phù hợp với tiêu chí tìm kiếm của bạn.') }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if (count($dataPaginate) > 0)
                        <div class="mt-6">
                            @if (isset($input))
                                {{ $dataPaginate->appends($input)->links() }}
                            @else
                                {{ $dataPaginate->links() }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userShowModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                    <button type="button"
                        class="modal-close bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">{{ __('Đóng') }}</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ __('Chi tiết nguồn HTML') }}</h3>
                        <div class="mt-4 space-y-4">
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="font-medium text-gray-500">{{ __('ID') }}:</div>
                                <div class="col-span-2" id="user-id"></div>

                                <div class="font-medium text-gray-500">{{ __('Đường dẫn') }}:</div>
                                <div class="col-span-2" id="url"></div>

                                <div class="font-medium text-gray-500">{{ __('Quốc gia') }}:</div>
                                <div class="col-span-2" id="country"></div>

                                <div class="font-medium text-gray-500">{{ __('Nền tảng') }}:</div>
                                <div class="col-span-2" id="platform"></div>

                                <div class="font-medium text-gray-500">{{ __('Thiết bị') }}:</div>
                                <div class="col-span-2" id="device"></div>

                                <div class="font-medium text-gray-500">{{ __('Nguồn') }}:</div>
                                <div class="col-span-2" id="source"></div>

                                <div class="font-medium text-gray-500">{{ __('ID ứng dụng') }}:</div>
                                <div class="col-span-2" id="app_id"></div>

                                <div class="font-medium text-gray-500">{{ __('Phiên bản') }}:</div>
                                <div class="col-span-2" id="version"></div>

                                <div class="font-medium text-gray-500">{{ __('Ngày tạo') }}:</div>
                                <div class="col-span-2" id="created_at"></div>

                                <div class="font-medium text-gray-500">{{ __('Ghi chú') }}:</div>
                                <div class="col-span-2" id="note"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="modal-close mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        {{ __('Đóng') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 with Tailwind CSS classes
            $('#country-name, #app-name').select2({
                theme: 'tailwind',
                width: '100%'
            });

            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const dateParam = urlParams.get('date');

            // Initialize datepicker with Vietnamese localization
            $.datepicker.regional['vi'] = {
                closeText: '{{ __('Đóng') }}',
                prevText: '{{ __('Trước') }}',
                nextText: '{{ __('Sau') }}',
                currentText: '{{ __('Hôm nay') }}',
                monthNames: ['{{ __('Tháng 1') }}', '{{ __('Tháng 2') }}', '{{ __('Tháng 3') }}',
                    '{{ __('Tháng 4') }}', '{{ __('Tháng 5') }}', '{{ __('Tháng 6') }}',
                    '{{ __('Tháng 7') }}', '{{ __('Tháng 8') }}', '{{ __('Tháng 9') }}',
                    '{{ __('Tháng 10') }}', '{{ __('Tháng 11') }}', '{{ __('Tháng 12') }}'
                ],
                monthNamesShort: ['{{ __('Th1') }}', '{{ __('Th2') }}', '{{ __('Th3') }}',
                    '{{ __('Th4') }}', '{{ __('Th5') }}', '{{ __('Th6') }}',
                    '{{ __('Th7') }}', '{{ __('Th8') }}', '{{ __('Th9') }}',
                    '{{ __('Th10') }}', '{{ __('Th11') }}', '{{ __('Th12') }}'
                ],
                dayNames: ['{{ __('Chủ nhật') }}', '{{ __('Thứ hai') }}', '{{ __('Thứ ba') }}',
                    '{{ __('Thứ tư') }}', '{{ __('Thứ năm') }}', '{{ __('Thứ sáu') }}',
                    '{{ __('Thứ bảy') }}'
                ],
                dayNamesShort: ['{{ __('CN') }}', '{{ __('T2') }}', '{{ __('T3') }}',
                    '{{ __('T4') }}', '{{ __('T5') }}', '{{ __('T6') }}',
                    '{{ __('T7') }}'
                ],
                dayNamesMin: ['{{ __('CN') }}', '{{ __('T2') }}', '{{ __('T3') }}',
                    '{{ __('T4') }}', '{{ __('T5') }}', '{{ __('T6') }}',
                    '{{ __('T7') }}'
                ],
                weekHeader: '{{ __('Tuần') }}',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['vi']);

            // Initialize datepicker
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date(),
                changeMonth: true,
                changeYear: true,
                yearRange: "2000:+0",
                showAnim: "fadeIn",
                beforeShow: function(input, inst) {
                    // Add custom class to the datepicker
                    setTimeout(function() {
                        inst.dpDiv.addClass('custom-datepicker');
                    }, 0);
                },
                onSelect: function(dateText) {
                    $(this).val(dateText);
                },
                onClose: function(selectedDate) {
                    if (selectedDate) {
                        const selected = new Date(selectedDate);
                        const current = new Date();
                        current.setHours(0, 0, 0, 0);

                        if (selected > current) {
                            $(this).val('');
                            const notification = document.createElement('div');
                            notification.className =
                                'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out';
                            notification.textContent =
                                '{{ __('Không thể chọn ngày trong tương lai') }}';
                            document.body.appendChild(notification);
                            setTimeout(() => notification.remove(), 3000);
                        }
                    }
                }
            });

            // Set initial date value
            if (dateParam) {
                $('#datepicker').datepicker('setDate', dateParam);
            } else {
                const today = new Date();
                $('#datepicker').datepicker('setDate', today);
            }

            // Add custom styles for the datepicker
            const style = document.createElement('style');
            style.textContent = `
                .ui-datepicker {
                    background-color: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 0.5rem;
                    padding: 0.5rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }
                .ui-datepicker-header {
                    background: none;
                    border: none;
                    padding: 0.5rem;
                    font-weight: 600;
                }
                .ui-datepicker-calendar thead th {
                    padding: 0.25rem;
                    font-weight: 500;
                }
                .ui-datepicker-calendar tbody td {
                    padding: 0;
                }
                .ui-datepicker-calendar tbody td a {
                    border: none;
                    background: none;
                    text-align: center;
                    padding: 0.25rem;
                }
                .ui-datepicker-calendar tbody td a.ui-state-active {
                    background-color: #4f46e5;
                    color: white;
                    border-radius: 0.25rem;
                }
                .ui-datepicker-calendar tbody td a.ui-state-hover {
                    background-color: #e5e7eb;
                    border-radius: 0.25rem;
                }
                .ui-datepicker-prev, .ui-datepicker-next {
                    background: none !important;
                    border: none !important;
                    right: 0;
                    cursor: pointer;
                }
                .ui-datepicker-prev span, .ui-datepicker-next span {
                    display: none;
                }
                .ui-datepicker-prev:before {
                    content: '←';
                    font-size: 1.2rem;
                }
                .ui-datepicker-next:before {
                    content: '→';
                    font-size: 1.2rem;
                }
            `;
            document.head.appendChild(style);

            // Copy functionality
            document.querySelectorAll('button[data-type="copy"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    const sourceText = this.closest('td').querySelector('button[data-type="email"]')
                        .innerText;
                    navigator.clipboard.writeText(sourceText).then(() => {
                        // Show success notification
                        const notification = document.createElement('div');
                        notification.className =
                            'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out';
                        notification.textContent =
                            '{{ __('Đã sao chép HTML vào clipboard') }}';
                        document.body.appendChild(notification);
                        setTimeout(() => notification.remove(), 3000);
                    });
                });
            });

            // Modal functionality
            const modal = document.getElementById('userShowModal');

            // Show modal
            document.querySelectorAll('.details-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            Object.keys(data).forEach(key => {
                                const element = document.getElementById(key);
                                if (element) element.textContent = data[key] || '';
                            });
                            modal.classList.remove('hidden');
                        });
                });
            });

            // Close modal
            document.querySelectorAll('.modal-close').forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            // Search functionality
            $("#search-report").on("click", function() {
                const params = new URLSearchParams({
                    date: $('#datepicker').val(),
                    app: $('#app-name').val(),
                    textSource: $('#text-source').val(),
                    device: $('#text-device').val(),
                    country: $('#country-name').val()
                });
                window.location.href = '?' + params.toString();
            });
        });
    </script>
@endsection
