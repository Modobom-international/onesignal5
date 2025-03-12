@extends('layouts.app')

@section('title')
    {{ __('Theo dõi người dùng') }}
@endsection

@section('styles')
    <link href="{{ asset('css/users-tracking.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="py-8">
        <!-- Page Header -->
        <div class="border-border border-b pb-6">
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Theo dõi người dùng') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Xem và phân tích hành vi người dùng trên website') }}</p>
        </div>

        <div class="mt-6">
            <!-- Filters Section -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="domain">
                            {{ __('Chọn tên miền') }}
                        </label>
                        <select id="domain"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="apkafe.com">apkafe.com</option>
                            <option value="vnitourist.com">vnitourist.com</option>
                            <option value="vnifood.com">vnifood.com</option>
                            <option value="betonamuryori.com">betonamuryori.com</option>
                            <option value="lifecompass365.com">lifecompass365.com</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="date">
                            {{ __('Chọn ngày') }}
                        </label>
                        <input type="date" id="date" value="{{ date('Y-m-d') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-end">
                        <button onclick="handleListUsers()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Tìm kiếm') }}
                        </button>

                        <button id="btn-heat-map" data-modal-target="heatMapModal" data-modal-toggle="heatMapModal"
                                class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            {{ __('Xem bản đồ nhiệt') }}
                        </button>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="mt-4">
                    <x-table>
                        <x-table.header class="border-t border-gray-200">
                            <x-table.row>
                                <x-table.head>Id</x-table.head>
                                <x-table.head>{{ __('Thời gian cuối cùng') }}</x-table.head>
                                <x-table.head>{{ __('Địa chỉ IP') }}</x-table.head>
                                <x-table.head>{{ __('Thiết bị') }}</x-table.head>
                                <x-table.head class="relative">
                                    <span class="sr-only">{{ __('Hành động') }}</span>
                                </x-table.head>
                            </x-table.row>
                        </x-table.header>

                        <x-table.body>
                            @foreach($data as $uuid => $record)
                                <x-table.row>
                                    <x-table.cell>{{ $uuid }}</x-table.cell>
                                    <x-table.cell>{{ $record[0]->timestamp }}</x-table.cell>
                                    <x-table.cell>{{ $record[0]->ip }}</x-table.cell>
                                    <x-table.cell>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $record[0]->screen_width <= 576 ? 'bg-purple-100 text-purple-800' :
                                       ($record[0]->screen_width <= 1024 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    @if($record[0]->screen_width <= 576)
                                        Mobile
                                    @elseif($record[0]->screen_width <= 1024)
                                        Tablet
                                    @else
                                        Desktop
                                    @endif
                                </span>
                                    </x-table.cell>
                                    <x-table.cell class="text-right">
                                        <button type="button" data-modal-target="detail-modal"
                                                data-modal-toggle="detail-modal"
                                                data-uuid="{{ $uuid }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                            {{ __('Chi tiết') }}
                                        </button>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-table.body>
                    </x-table>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $data->appends(request()->except('page'))->links() }}


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        >
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="bg-white rounded-lg shadow-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Chi tiết') }} <span id="uuid-modal"></span>
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-hide="detail-modal">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <!-- Basic Info Card -->
                    <div id="basic-info-modal" class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h5 class="text-lg font-medium text-gray-900 mb-4">{{ __('Thông tin cơ bản') }}</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <p class="mb-2">{{ __('Địa chỉ IP') }}: <span id="ip-modal"
                                                                              class="font-medium text-gray-900"></span>
                                </p>
                                <p class="mb-2">{{ __('Trình duyệt') }}: <span id="browser-modal"
                                                                               class="font-medium text-gray-900"></span>
                                </p>
                                <p class="mb-2">{{ __('Hệ thống') }}: <span id="os-modal"
                                                                            class="font-medium text-gray-900"></span>
                                </p>
                            </div>
                            <div>
                                <p class="mb-2">{{ __('Thiết bị') }}: <span id="device-modal"
                                                                            class="font-medium text-gray-900"></span>
                                </p>
                                <p class="mb-2">{{ __('Nhấp vào đường dẫn nội bộ') }}: <span id="internal-modal"
                                                                                             class="font-medium text-gray-900"></span>
                                </p>
                                <p class="mb-2">{{ __('Nhấp vào nút lasso') }}: <span id="lasso-modal"
                                                                                      class="font-medium text-gray-900"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="loading">
                        @include('components.pre-loader')
                    </div>

                    <div id="activity-modal" class="space-y-4"></div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" data-modal-hide="detail-modal"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ __('Đóng') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Heat Map Modal -->
    <div id="heatMapModal" tabindex="-1"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-6xl max-h-full">
            <div class="bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Bản đồ nhiệt') }}</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-hide="heatMapModal">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <!-- Filters Card -->
                    <div id="card-in-heat-map-modal" class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <label
                                    class="inline-block px-2 py-1 text-sm font-medium bg-indigo-100 text-indigo-700 rounded-full mb-2"
                                    for="domain-heat-map-modal">
                                    {{ __('Chọn tên miền') }}
                                </label>
                                <select id="domain-heat-map-modal"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="apkafe.com">apkafe.com</option>
                                    <option value="vnitourist.com">vnitourist.com</option>
                                    <option value="vnifood.com">vnifood.com</option>
                                    <option value="betonamuryori.com">betonamuryori.com</option>
                                    <option value="lifecompass365.com">lifecompass365.com</option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="inline-block px-2 py-1 text-sm font-medium bg-indigo-100 text-indigo-700 rounded-full mb-2"
                                    for="path-heat-map-modal">
                                    {{ __('Chọn đường dẫn') }}
                                </label>
                                <select id="path-heat-map-modal"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </select>
                            </div>

                            <div>
                                <label
                                    class="inline-block px-2 py-1 text-sm font-medium bg-indigo-100 text-indigo-700 rounded-full mb-2"
                                    for="date-heat-map-modal">
                                    {{ __('Chọn ngày') }}
                                </label>
                                <input type="date" id="date-heat-map-modal" value="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label
                                    class="inline-block px-2 py-1 text-sm font-medium bg-indigo-100 text-indigo-700 rounded-full mb-2"
                                    for="event-heat-map-modal">
                                    {{ __('Chọn sự kiện') }}
                                </label>
                                <select id="event-heat-map-modal"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="mousemove">{{ __('Di chuột') }}</option>
                                    <option value="click">{{ __('Nhấp chuột') }}</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button id="choose-heat-map"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Chọn') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div class="loading">
                        @include('components.pre-loader')
                    </div>

                    <!-- Heat Map Area -->
                    <div class="area-heat-map hidden">
                        <div class="relative">
                            <img id="heatmapimage" class="w-full h-auto">
                            <div id="heatmap" class="absolute top-0 left-0 w-full h-full"></div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex justify-end">
                        <button type="button" data-modal-hide="heatMapModal"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ __('Đóng') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>
    <script>
        var heatmapInstance = null;
        var isFetching = false;

        const container = document.getElementById('heatmap');

        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-modal-toggle="detail-modal"]')) {
                if (isFetching) return;
                isFetching = true;

                const uuid = e.target.dataset.uuid;
                document.querySelector(".loading").style.display = "block";
                document.getElementById('activity-modal').innerHTML = '';
                document.getElementById('basic-info-modal').style.display = 'none';

                fetch(`{{ route("users.tracking.detail") }}?uuid=${uuid}`)
                    .then(response => response.json())
                    .then(response => {
                        document.querySelector(".loading").style.display = "none";
                        document.getElementById('basic-info-modal').style.display = 'block';
                        document.getElementById('uuid-modal').textContent = uuid;
                        document.getElementById('ip-modal').textContent = response.ip;
                        document.getElementById('browser-modal').textContent = response.browser;
                        document.getElementById('os-modal').textContent = response.os;
                        document.getElementById('device-modal').textContent = response.device;
                        document.getElementById('lasso-modal').textContent = response.is_lasso_button == 1 ? 'Có' : 'Không';
                        document.getElementById('internal-modal').textContent = response.is_internal_link == 1 ? 'Có' : 'Không';

                        let activityHtml = '';
                        for (let path in response.activity) {
                            let activity = response.activity[path];
                            activityHtml += `
                                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                                    <h5 class="font-medium text-gray-900 mb-3">${path}</h5>
                                    <hr class="my-2">
                                    <ul class="space-y-2">
                                        ${activity.map(item => `<li class="text-gray-600">${item}</li>`).join('')}
                                    </ul>
                                </div>`;
                        }
                        document.getElementById('activity-modal').innerHTML = activityHtml;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        isFetching = false;
                    });
            }
        });

        document.querySelectorAll('[data-modal-hide="detail-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                isFetching = false;
            });
        });

        $('#heatMapModal').on('show.bs.modal', function (e) {
            getPathByDomain();
        });

        $('#domain-heat-map-modal').on('change', function (e) {
            getPathByDomain();
        })

        $('#choose-heat-map').on('click', function () {
            $(".loading").show();
            $('.area-heat-map').hide();
            var domain = $('#domain-heat-map-modal').val();
            var path = $('#path-heat-map-modal').val();
            var date = $('#date-heat-map-modal').val();
            var event = $('#event-heat-map-modal').val();

            $.ajax({
                url: '{{ route("users.tracking.heat.map") }}',
                type: 'GET',
                data: {
                    domain: domain,
                    path: path,
                    date: date,
                    event: event
                },
                success: function (response) {
                    var data = [];
                    $('#heatmapimage').attr('src', response.path_image);
                    var height = $('#heatmapimage').height;
                    $('#heatmap').attr('style', 'height: ' + height + 'px ' + '!important');

                    for (let i in response.data) {
                        data.push({
                            x: response.data[i].x,
                            y: response.data[i].y,
                            value: response.data[i].value
                        });
                    }

                    createHeatmap(data);
                }
            });
        });

        function createHeatmap(data) {
            if (heatmapInstance) {
                $('#heatmap').empty();
            }

            heatmapInstance = h337.create({
                container: container,
                radius: 30,
                maxOpacity: 0.2,
                minOpacity: 0,
                blur: 0.2,
                gradient: {
                    0.4: "blue",
                    0.6: "green",
                    0.8: "yellow",
                    1.0: "red"
                }
            });

            heatmapInstance.setData({
                max: 10,
                data: data
            });

            $(".loading").hide();
            $('.area-heat-map').show();
        }

        function getPathByDomain() {
            var domain = $('#domain-heat-map-modal').val();

            $('#card-in-heat-map-modal').hide();
            $('.area-heat-map').hide();
            $('#path-heat-map-modal').empty();
            $.ajax({
                url: '{{ route("users.tracking.link.heat.map") }}',
                type: 'GET',
                data: {
                    domain: domain,
                },
                success: function (response) {
                    for (let i = 0; i < response.length; i++) {
                        $('#path-heat-map-modal').append('<option value="' + response[i] + '">' + response[i] + '</option>');
                    }
                    $(".loading").hide();
                    $('#card-in-heat-map-modal').show();
                }
            });
        }

        function handleListUsers() {

        }
    </script>
@endsection
