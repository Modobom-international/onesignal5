@props(['notificationSystem'])

<div class="relative" x-data="{ unreadCount: {{ count($notificationSystem->where('status_read', 0)) }}, notificationOpen: false }">
    <x-button type="button"
        class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
        icon-only variant="secondary" @click="notificationOpen = !notificationOpen"
        @click.outside="notificationOpen = false">
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
        class="absolute right-0 mt-2 w-80 rounded-lg shadow-lg bg-white dark:bg-[#161b22] ring-1 ring-black/5 dark:ring-[#30363d]">
        <div class="p-1 divide-y divide-gray-100 dark:divide-[#30363d]">
            <!-- Header -->
            <div class="px-3 py-2 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-[#c9d1d9]">Notifications</h3>
                <button x-show="unreadCount > 0" @click="unreadCount = 0"
                    class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Mark all as read
                </button>
            </div>

            <!-- Notification List -->
            <div class="py-1 max-h-64 overflow-y-auto">
                @forelse ($notificationSystem as $notification)
                    <div class="px-3 py-2 hover:bg-slate-50 dark:hover:bg-[#1f2428] cursor-pointer {{ $notification->status_read == 0 ? 'bg-slate-50 dark:bg-[#1c2128]' : '' }}"
                        @click="$event.target.closest('div').classList.remove('bg-slate-50', 'dark:bg-[#1c2128]')">
                        <p class="text-sm text-slate-600 dark:text-[#c9d1d9]">{{ $notification->message }}</p>
                        <span class="text-xs text-slate-400 dark:text-[#8b949e] mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="px-3 py-2">
                        <p class="text-sm text-slate-500 dark:text-[#8b949e]">{{ __('No notifications') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            @if (count($notificationSystem) > 0)
                <div class="py-1">
                    <a href="#"
                        class="block px-3 py-2 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-700/50">
                        View all notifications
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
