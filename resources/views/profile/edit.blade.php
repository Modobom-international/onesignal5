@extends('layouts.app')

@section('title', __('Hồ sơ'))

@section('content')

    <div class=" py-10 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-3">
                <div class="space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-6">
                            <!-- Avatar -->
                            <div class="flex justify-center">
                                <div class="h-32 w-32 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <span class="text-5xl font-medium text-white">
                                        {{ substr(auth()->user()->name ?? '', 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Name and Email -->
                            <div class="mt-4 text-center">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <!-- Role Badge -->
                            <div class="mt-4 flex justify-center">
                                <span class="px-3 py-1 text-xs font-medium text-indigo-600 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ Str::title(str_replace('-', ' ', auth()->user()->getRoleNames()->first())) ?? __('Nhân viên') }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 grid grid-cols-2 divide-x divide-gray-200 dark:divide-gray-700">
                            <div class="px-4 py-3 text-center">
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Vị trí') }}</span>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->position ?? __('Chưa cập nhật') }}</span>
                            </div>
                            <div class="px-4 py-3 text-center">
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Nhóm') }}</span>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->team ?? __('Chưa cập nhật') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Thông tin bổ sung') }}</h3>
                            <dl class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">{{ __('Ngày tham gia') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->created_at->format('d/m/Y') }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">{{ __('Lương') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format(auth()->user()->salary ?? 0, 0, ',', '.') }} VNĐ</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-9 mt-6 lg:mt-0">
                <div class="space-y-6">
                    <!-- Profile Information Form -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Thông tin cá nhân') }}
                                </h2>

                            </div>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Password Update Form -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Bảo mật') }}
                                </h2>

                            </div>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-red-200 dark:border-red-900">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Vùng nguy hiểm') }}
                                </h2>

                            </div>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
