@props(['notificationSystem'])

<div class="relative" x-data="{ unreadCount: {{ count($notificationSystem->where('status_read', 0)) }}, notificationOpen: false, selected: 'unread' }"
    @click.outside="if (!$event.target.closest('.notification-dropdown')) notificationOpen = false">
    <x-button type="button"
        class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
        icon-only variant="secondary" @click="notificationOpen = !notificationOpen">
        <x-icons.bell class="w-4 h-4 text-slate-600 dark:text-slate-400" aria-hidden="true" />
        <!-- Notification Badge -->
        <div x-show="unreadCount > 0" class="absolute -top-0.5 -right-0.5 flex items-center justify-center">
            <span class="flex h-2 w-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
        </div>
    </x-button>

    <!-- Notification Dropdown -->
    <div x-show="notificationOpen" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-[448px] rounded-lg shadow-lg bg-white dark:bg-[#161b22] ring-1 ring-black/5 dark:ring-[#30363d] notification-dropdown">
        <div class="divide-y divide-gray-100 dark:divide-[#30363d]">
            <!-- Header -->
            <div class="px-4 py-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-[#c9d1d9]">{{ __('Thông báo') }}</h3>

                </div>

                <!-- Minimal Tab Design -->
                <div class="flex p-1 bg-gray-100 dark:bg-gray-800/50 rounded-lg">
                    <button @click.stop="selected = 'unread'"
                        :class="{
                            'bg-white dark:bg-gray-700 shadow-sm': selected === 'unread',
                            'hover:bg-gray-50 dark:hover:bg-gray-700/50': selected !== 'unread'
                        }"
                        class="flex-1 text-sm py-1.5 px-4 rounded-md transition-all duration-200" role="tab">
                        <span
                            :class="{
                                'text-gray-900 dark:text-white font-medium': selected === 'unread',
                                'text-gray-600 dark:text-gray-400': selected !== 'unread'
                            }">{{ __('Chưa đọc') }}</span>
                    </button>
                    <button @click.stop="selected = 'all'"
                        :class="{
                            'bg-white dark:bg-gray-700 shadow-sm': selected === 'all',
                            'hover:bg-gray-50 dark:hover:bg-gray-700/50': selected !== 'all'
                        }"
                        class="flex-1 text-sm py-1.5 px-4 rounded-md transition-all duration-200" role="tab">
                        <span
                            :class="{
                                'text-gray-900 dark:text-white font-medium': selected === 'all',
                                'text-gray-600 dark:text-gray-400': selected !== 'all'
                            }">{{ __('Tất cả') }}</span>
                    </button>
                </div>
            </div>

            <!-- Notification List -->
            <div class="overflow-y-auto" style="max-height: calc(100vh - 200px)">
                <div class="divide-y divide-gray-100 dark:divide-[#30363d]">
                    @forelse ($notificationSystem as $notification)
                        <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#1f2428] cursor-pointer {{ $notification->status_read == 0 ? 'bg-gray-50 dark:bg-[#1c2128]' : '' }}"
                            x-show="selected === 'all' || (selected === 'unread' && {{ $notification->status_read }} === 0)"
                            data-notification data-read="{{ $notification->status_read === 1 ? 'true' : 'false' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 dark:text-[#c9d1d9] leading-5">
                                        {{ $notification->message }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-[#8b949e]">
                                        {{ $notification->created_at->locale('vi')->diffForHumans() }}
                                    </p>
                                </div>
                                <button @click.stop
                                    class="text-gray-400 dark:text-[#8b949e] hover:text-gray-500 dark:hover:text-[#c9d1d9]">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-16 text-center">
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-1">{{ __('Bạn đã cập nhật tất cả') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Không có thông báo mới vào lúc này') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 sm:px-6 flex justify-between items-center bg-gray-50 dark:bg-[#161b22]">
                <span class="text-xs text-gray-500 dark:text-[#8b949e]">
                    {{ count($notificationSystem) }} {{ __('trong tổng số') }} {{ count($notificationSystem) }} {{ __('thông báo') }}
                </span>
                <a href="#" @click.stop
                    class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                    {{ __('Xem tất cả') }}
                </a>
            </div>
        </div>
    </div>
</div>
