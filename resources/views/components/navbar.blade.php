<nav aria-label="primary" x-data="{ open: false, notificationOpen: false }"
    class="sticky top-0 left-0 right-0 z-50 backdrop-blur flex-none transition-colors duration-300 border-b border-slate-900/10 dark:border-[#30363d] bg-white/95  dark:bg-[#0d1117]">
    <div class="h-14 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <x-button type="button" icon-only variant="secondary" sr-text="Open main menu"
                x-on:click="isSidebarOpen = !isSidebarOpen"
                class="md:hidden h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true"
                    class="w-4 h-4 text-slate-600 dark:text-slate-400" />
                <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true"
                    class="w-4 h-4 text-slate-600 dark:text-slate-400" />
            </x-button>

            <!-- Left side - Logo and Toggle -->
            <div class="flex items-center gap-3">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <x-application-logo aria-hidden="true" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <!-- Right side - Actions -->
        <div class="flex items-center gap-2">
            <!-- Search Button -->
            <x-button type="button" icon-only variant="secondary" sr-text="Search"
                class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                <x-heroicon-o-search aria-hidden="true" class="w-4 h-4 text-slate-600 dark:text-slate-400" />
            </x-button>

            <!-- Notification Button -->
            <div class="relative" x-data="{ unreadCount: {{ count($notificationSystem->where('status_read', 0)) }} }">
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
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
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
                                    <p class="text-sm text-slate-600 dark:text-[#c9d1d9]">{{ $notification->message }}
                                    </p>
                                    <span class="text-xs text-slate-400 dark:text-[#8b949e] mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @empty
                                <div class="px-3 py-2">
                                    <p class="text-sm text-slate-500 dark:text-[#8b949e]">{{ __('No notifications') }}
                                    </p>
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

            <!-- Theme Toggle -->
            <x-button type="button"
                class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
                icon-only variant="secondary" sr-text="Toggle dark mode" x-on:click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true"
                    class="w-4 h-4 text-slate-600 dark:text-slate-400" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true"
                    class="w-4 h-4 text-slate-600 dark:text-slate-400" />
            </x-button>

            <!-- User Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-2 h-8 pl-2 pr-1 text-sm font-medium rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200 border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                        <span class="h-6 w-6 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span class="text-xs font-medium text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </span>
                        <span class="hidden sm:block text-sm text-slate-700 dark:text-slate-300">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="p-1">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-slate-500 dark:text-slate-400" />
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <x-heroicon-o-logout class="w-4 h-4 mr-2 text-slate-500 dark:text-slate-400" />
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
