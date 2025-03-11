@extends('layouts.app')

@section('title', __('Tên miền'))

@section('styles')
    <link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="py-8">
        <!-- Page Header -->
        <div class="border-border border-b pb-6">
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Tên miền') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Xem và quản lý thông tin tên miền') }}</p>
        </div>

        <div class="mt-6">
            <!-- Filters Section -->
            <div class="space-y-6">
                @if (Auth::user()->email == 'vutuan.modobom@gmail.com' or Auth::user()->email == 'tranlinh.modobom@gmail.com')
                    <div class="flex justify-between items-center">
                        <a href="{{ route('domain.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Thêm tên miền') }}
                        </a>

                        <div class="w-64">
                            <input type="text" id="search-domain"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="{{ __('Nhập tên domain...') }}">
                        </div>
                    </div>
                @endif


                <!-- Results Table -->
                <div class="mt-4">
                    <div id="table-domain">
                        @if (count($domains) > 0)
                            <x-table>
                                <x-table.header class="border-t border-gray-200">
                                    <x-table.row>
                                        <x-table.head>{{ __('Tên miền') }}</x-table.head>
                                        <x-table.head>{{ __('Tài khoản đăng nhập') }}</x-table.head>
                                        <x-table.head>{{ __('Mật khẩu đăng nhập') }}</x-table.head>
                                        <x-table.head>{{ __('Ngày tạo') }}</x-table.head>
                                        <x-table.head>{{ __('Người quản lý') }}</x-table.head>
                                        <x-table.head>{{ __('Máy chủ') }}</x-table.head>
                                        <x-table.head>{{ __('Trạng thái') }}</x-table.head>
                                        <x-table.head class="relative">
                                            <span class="sr-only">{{ __('Hành động') }}</span>
                                        </x-table.head>
                                    </x-table.row>
                                </x-table.header>

                                <x-table.body>
                                    @foreach ($domains as $domain)
                                        <x-table.row>
                                            <x-table.cell>{{ $domain->domain }}</x-table.cell>
                                            <x-table.cell>{{ $domain->admin_username }}</x-table.cell>
                                            <x-table.cell>{{ $domain->admin_password }}</x-table.cell>
                                            <x-table.cell>{{ $domain->created_at }}</x-table.cell>
                                            <x-table.cell>{{ $domain->email }}</x-table.cell>
                                            <x-table.cell>{{ $domain->server }}</x-table.cell>
                                            <x-table.cell>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $domain->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $domain->status ? __('Hoạt động') : __('Không hoạt động') }}
                                                </span>
                                            </x-table.cell>
                                            <x-table.cell class="text-right space-x-2">
                                                <button type="button" data-modal-target="detail-modal"
                                                    data-modal-toggle="detail-modal"
                                                    data-domain-details="{{ json_encode([
                                                        'domain' => $domain->domain,
                                                        'admin_username' => $domain->admin_username,
                                                        'admin_password' => $domain->admin_password,
                                                        'created_at' => $domain->created_at,
                                                        'email' => $domain->email,
                                                        'server' => $domain->server,
                                                        'status' => $domain->status,
                                                    ]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('Chi tiết') }}
                                                </button>

                                                @if (Auth::user()->email == 'vutuan.modobom@gmail.com' or Auth::user()->email == 'tranlinh.modobom@gmail.com')
                                                    <button type="button" data-domain="{{ $domain->domain }}"
                                                        data-bs-toggle="modal" data-bs-target="#modalDeleteDomain"
                                                        class="text-red-600 hover:text-red-900">
                                                        {{ __('Xóa') }}
                                                    </button>
                                                @endif
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforeach
                                </x-table.body>
                            </x-table>

                            <!-- Add Pagination Links -->
                            <div class="mt-6">
                                {{ $domains->appends(request()->except('page'))->links() }}
                            </div>
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
                                    <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('Không tìm thấy dữ liệu') }}
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        {{ __('Bạn có thể thay đổi bộ lọc hoặc tìm kiếm lại để mở rộng kết quả.') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keep your existing modals here -->
    @include('domain.modals.detail')
    @include('domain.modals.delete')


@endsection

@section('scripts')
    <script>
        $(function() {
            // Initialize the detail modal
            const detailModal = document.getElementById('detail-modal');
            const modal = new Modal(detailModal);

            // Handle detail button click
            $(document).on('click', '[data-modal-target="detail-modal"]', function(e) {
                e.preventDefault();
                const domainData = JSON.parse($(this).attr('data-domain-details'));
                updateDetailModal(domainData);

            });

            // Function to update modal content
            function updateDetailModal(data) {
                $('#domain-modal').text(data.domain || '-');
                $('#admin_username-modal').text(data.admin_username || '-');
                $('#admin_password-modal').text(data.admin_password || '-');
                $('#created_at-modal').text(data.created_at || '-');
                $('#email-modal').text(data.email || '-');
                $('#server-modal').text(data.server || '-');

                // Update status with proper styling
                const statusElement = $('#status-modal');
                if (data.status) {
                    statusElement
                        .removeClass('bg-red-100 text-red-800')
                        .addClass('bg-green-100 text-green-800')
                        .text('{{ __('Hoạt động') }}');
                } else {
                    statusElement
                        .removeClass('bg-green-100 text-green-800')
                        .addClass('bg-red-100 text-red-800')
                        .text('{{ __('Không hoạt động') }}');
                }
            }

            // Keep your existing search functionality
            var typingTimer;
            var doneTypingInterval = 500;

            $('#search-domain').on('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(performSearch, doneTypingInterval);
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                $.ajax({
                    url: "{{ route('domain.search') }}",
                    type: "GET",
                    data: {
                        query: $('#search-domain').val(),
                        page: page
                    },
                    success: function(response) {
                        $('#table-domain').html(response.html);
                    }
                });
            });
        });

        function performSearch() {
            var query = $('#search-domain').val();

            $.ajax({
                url: "{{ route('domain.search') }}",
                type: "GET",
                data: {
                    query: query
                },
                success: function(response) {
                    $('#table-domain').html(response.html);
                }
            });
        }

        function removeDomain() {
            var domain = $('#domain-in-hidden').val();

            $.ajax({
                url: "{{ route('domain.delete') }}",
                type: "GET",
                data: {
                    domain: domain
                },
                success: function(response) {

                }
            });
        }
    </script>
@endsection
