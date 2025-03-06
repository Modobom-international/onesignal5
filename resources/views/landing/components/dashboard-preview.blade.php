<!-- Dashboard Preview -->
<div class="mt-16 relative">
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-full h-72 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-5xl">
        <!-- Browser Window Frame -->
        <div class="rounded-2xl shadow-2xl ring-1 ring-gray-900/10 overflow-hidden backdrop-blur-sm">
            <!-- Browser Header -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-4">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <div class="ml-4 flex-1 flex justify-center">
                        <div class="flex items-center space-x-2 px-3 py-1 bg-gray-700/50 rounded-lg">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-sm text-gray-300">hr.modobom.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="bg-white">
                <div class="grid grid-cols-12 gap-6 p-6">
                    <!-- Sidebar -->
                    <div class="col-span-3 bg-gray-50 rounded-xl p-4">
                        <div class="space-y-4">
                            <div class="p-2 bg-white rounded-lg shadow-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ __('Tổng quan') }}</span>
                                </div>
                            </div>
                            <div class="p-2 hover:bg-white rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600">{{ __('Nhân viên') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-span-9 space-y-6">
                        <!-- Stats Row -->
                        <div class="grid grid-cols-3 gap-6">
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6">
                                <div class="text-sm font-medium text-indigo-600">{{ __('Tổng nhân viên') }}</div>
                                <div class="mt-2 flex items-baseline">
                                    <span class="text-3xl font-bold text-gray-900">2,420</span>
                                    <span class="ml-2 text-sm text-green-500">+12</span>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6">
                                <div class="text-sm font-medium text-green-600">{{ __('Tỷ lệ hài lòng') }}</div>
                                <div class="mt-2 flex items-baseline">
                                    <span class="text-3xl font-bold text-gray-900">95.8%</span>
                                    <span class="ml-2 text-sm text-green-500">+2.4%</span>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6">
                                <div class="text-sm font-medium text-purple-600">{{ __('Hiệu suất') }}</div>
                                <div class="mt-2 flex items-baseline">
                                    <span class="text-3xl font-bold text-gray-900">94.2%</span>
                                    <span class="ml-2 text-sm text-green-500">+1.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900">{{ __('Hoạt động tuyển dụng') }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        +18.2%
                                    </span>
                                </div>
                            </div>
                            <div class="h-48">
                                <div class="h-full w-full flex items-end space-x-2">
                                    <div class="w-1/12 bg-indigo-900/10 rounded-t" style="height: 45%"></div>
                                    <div class="w-1/12 bg-indigo-900/20 rounded-t" style="height: 65%"></div>
                                    <div class="w-1/12 bg-indigo-900/30 rounded-t" style="height: 85%"></div>
                                    <div class="w-1/12 bg-indigo-900/40 rounded-t" style="height: 75%"></div>
                                    <div class="w-1/12 bg-indigo-900/50 rounded-t" style="height: 90%"></div>
                                    <div class="w-1/12 bg-indigo-900/60 rounded-t" style="height: 100%"></div>
                                    <div class="w-1/12 bg-indigo-900/70 rounded-t" style="height: 95%"></div>
                                    <div class="w-1/12 bg-indigo-900/80 rounded-t" style="height: 85%"></div>
                                    <div class="w-1/12 bg-indigo-900/90 rounded-t" style="height: 75%"></div>
                                    <div class="w-1/12 bg-indigo-900 rounded-t" style="height: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
