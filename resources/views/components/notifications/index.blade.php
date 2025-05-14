
<div class="relative"
    @click.outside="if (!$event.target.closest('.notification-dropdown')) notificationOpen = false">
    <x-button type="button"
        class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200"
        icon-only variant="ghost" @click="notificationOpen = !notificationOpen">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
        <!-- Notification Badge -->
        <div x-show="unreadCount > 0" class="absolute -top-0.5 -right-0.5 flex items-center justify-center">
            <span class="flex h-2 w-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-[#0d1117]"></span>
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
                <div class="flex p-1 bg-gray-100 dark:bg-[#0d1117] rounded-lg">
                    <button @click.stop="selected = 'unread'"
                        :class="{
                            'bg-white dark:bg-[#161b22] shadow-sm': selected === 'unread',
                            'hover:bg-gray-50 dark:hover:bg-[#1f242c]': selected !== 'unread'
                        }"
                        class="flex-1 text-sm py-1.5 px-4 rounded-md transition-all duration-200" role="tab">
                        <span
                            :class="{
                                'text-gray-900 dark:text-[#c9d1d9] font-medium': selected === 'unread',
                                'text-gray-600 dark:text-[#8b949e]': selected !== 'unread'
                            }">{{ __('Chưa đọc') }}</span>
                    </button>
                    <button @click.stop="selected = 'all'"
                        :class="{
                            'bg-white dark:bg-[#161b22] shadow-sm': selected === 'all',
                            'hover:bg-gray-50 dark:hover:bg-[#1f242c]': selected !== 'all'
                        }"
                        class="flex-1 text-sm py-1.5 px-4 rounded-md transition-all duration-200" role="tab">
                        <span
                            :class="{
                                'text-gray-900 dark:text-[#c9d1d9] font-medium': selected === 'all',
                                'text-gray-600 dark:text-[#8b949e]': selected !== 'all'
                            }">{{ __('Tất cả') }}</span>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            
        </div>
    </div>
</div>
