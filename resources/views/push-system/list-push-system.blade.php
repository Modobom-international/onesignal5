@extends('layouts.app')

@section('title', 'List Push System')

@section('content')
    <div class=" py-8">
        <div>
            <!-- Page Header -->
            <div class="mb-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Push System') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">
                            {{ __('Manage and monitor your push notification system statistics') }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:flex-none">
                        <a href="{{ route('push.system.config.link') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Config links push') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-sm ring-1 ring-gray-900/5 overflow-hidden">


                <div class="px-6 py-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
                        <!-- Total Users Card -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-200">
                            </div>
                            <div class="relative bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors cursor-pointer p-5"
                                id="count_total_user">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-500 truncate">{{ __('Tổng User') }}</p>
                                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($countUser) }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 p-3 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-full">
                                        <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 text-xs text-gray-500">
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ __('Click to view details') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Active Users Card -->
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-green-600 rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-200">
                            </div>
                            <div class="relative bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors cursor-pointer p-5"
                                id="count_total_user_active">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-500 truncate">
                                            {{ __('Tổng User hoạt động trong ngày') }}</p>
                                        <p class="mt-1 text-2xl font-semibold text-gray-900" id="users_active">
                                            {{ number_format($totalActive) }}</p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-full">
                                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 text-xs text-gray-500">
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ __('Auto-updates every 30 seconds') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div class="loading hidden">
                        <div
                            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity flex items-center justify-center z-50">
                            <div class="relative">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white"></div>
                                <div class="mt-4 text-white text-sm font-medium">{{ __('Loading...') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="mt-8">
                        <div class="sm:rounded-lg">
                            <div id="total_users">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Country') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Number of users') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach ($activeByCountry as $country => $total)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                        {{ $country }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        {{ number_format($total) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="total_active_users" class="hidden">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Country') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Number of users') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach ($activeByCountry as $country => $total)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                        {{ $country }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        {{ number_format($total) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
        $(document).ready(function() {
            $('#total_active_users').hide();
            $(".loading").hide();

            // Show loading indicator during AJAX requests
            $(document).ajaxStart(function() {
                $(".loading").removeClass('hidden');
            });

            $(document).ajaxStop(function() {
                $(".loading").addClass('hidden');
            });

            $(document).ajaxError(function() {
                $(".loading").addClass('hidden');
            });

            setInterval(loadUsersActive, 30000);

            // Tab switching functionality
            $("#tab_total_users, #count_total_user").click(function() {
                // Update tab styles
                $("#tab_total_users").addClass('border-indigo-500 text-indigo-600')
                    .removeClass(
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                $("#tab_active_users").removeClass('border-indigo-500 text-indigo-600')
                    .addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                // Update card styles
                $("#count_total_user").addClass('ring-2 ring-indigo-600').siblings().removeClass(
                    'ring-2 ring-indigo-600');
                $("#count_total_user_active").removeClass('ring-2 ring-indigo-600');

                // Show/hide content
                $('#total_users').removeClass('hidden');
                $('#total_active_users').addClass('hidden');

                if ($(this).attr('id') === 'count_total_user') {
                    location.reload();
                }
            });

            $("#tab_active_users, #count_total_user_active").click(function() {
                // Update tab styles
                $("#tab_active_users").addClass('border-indigo-500 text-indigo-600')
                    .removeClass(
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                $("#tab_total_users").removeClass('border-indigo-500 text-indigo-600')
                    .addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                // Update card styles
                $("#count_total_user_active").addClass('ring-2 ring-indigo-600').siblings().removeClass(
                    'ring-2 ring-indigo-600');
                $("#count_total_user").removeClass('ring-2 ring-indigo-600');

                // Show/hide content
                $('#total_users').addClass('hidden');
                $('#total_active_users').removeClass('hidden');

                loadUsersActive();
            });
        });

        function loadUsersActive() {
            $.ajax({
                url: '{{ route('push.system.list.user.active.ajax') }}',
                type: 'GET',
                success: function(data) {
                    $('#users_active').text(new Intl.NumberFormat().format(data.total));
                    $('#total_active_users table tbody').empty();

                    $.each(data.usersActiveCountry, function(key, record) {
                        var split = record.key.split("_");
                        var country = split[6];
                        $('#total_active_users table tbody').append(`
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                            ${country}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            ${new Intl.NumberFormat().format(record.total)}
                        </td>
                    </tr>
                `);
                    });
                }
            });
        }
    </script>
@endsection
