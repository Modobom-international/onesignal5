<nav aria-label="primary" x-data="{ open: false }"
    class="fixed top-0 left-0 right-0 z-50 backdrop-blur flex-none transition-colors duration-300 border-b border-slate-900/10 dark:border-slate-50/[0.06] bg-white/95 supports-backdrop-blur:bg-white/60 dark:bg-transparent"
    :class="{ '-translate-y-full': scrollingDown, 'translate-y-0': scrollingUp }">
    <div class="h-14 flex items-center justify-between px-4">
        <!-- Left side - Logo and Toggle -->
        <div class="flex items-center gap-3">


            <!-- Logo -->
            <div class="flex items-center gap-2">
                <x-application-logo aria-hidden="true" class="w-6 h-6" />

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
            <div class="relative">
                <x-button type="button"
                    class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200"
                    icon-only variant="secondary" onclick="displayNotification()">
                    <x-icons.bell class="w-4 h-4 text-slate-600 dark:text-slate-400" aria-hidden="true" />
                    <div id="bell-notification" class="hide absolute -top-0.5 -right-0.5">
                        <span class="flex h-2 w-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
                    </div>
                </x-button>

                <!-- Notification Dropdown -->
                <div class="dropdown-menu absolute right-0 mt-1 w-80 rounded-lg shadow-lg bg-white dark:bg-slate-800 ring-1 ring-black/5 dark:ring-white/10"
                    id="dropdown-notification">
                    <div class="p-1">
                        @if (count($notificationSystem) > 0)
                            @foreach ($notificationSystem as $notification)
                                <div id="{{ $notification->id->__toString() }}"
                                    class="px-3 py-2 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer {{ $notification->status_read == 0 ? 'bg-slate-50 dark:bg-slate-700/30' : '' }}">
                                    <p class="text-sm text-slate-600 dark:text-slate-300">
                                        {{ $notification->message }}</p>
                                </div>
                            @endforeach

                            @if (count($notificationSystem) == 4)
                                <div class="border-t border-slate-200 dark:border-slate-700 mt-1">
                                    <a href="#"
                                        class="block px-3 py-2 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-md">
                                        View all notifications
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="px-3 py-2">
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('No notifications') }}</p>
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

<!-- Mobile Bottom Navigation -->
<div class="fixed inset-x-0 bottom-0 z-50 flex items-center justify-between h-14 px-4 transition-transform duration-300 bg-white/95 backdrop-blur supports-backdrop-blur:bg-white/60 dark:bg-slate-900/75 border-t border-slate-900/10 dark:border-slate-50/[0.06] md:hidden"
    :class="{ 'translate-y-full': scrollingDown, 'translate-y-0': scrollingUp }">
    <x-button type="button" icon-only variant="secondary" sr-text="Search"
        class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
        <x-heroicon-o-search aria-hidden="true" class="w-4 h-4 text-slate-600 dark:text-slate-400" />
    </x-button>

    <a href="{{ route('dashboard') }}" class="flex items-center">
        <x-application-logo aria-hidden="true" class="w-6 h-6" />
        <span class="sr-only">Dashboard</span>
    </a>

    <x-button type="button" icon-only variant="secondary" sr-text="Open main menu"
        x-on:click="isSidebarOpen = !isSidebarOpen"
        class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
        <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true"
            class="w-4 h-4 text-slate-600 dark:text-slate-400" />
        <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="w-4 h-4 text-slate-600 dark:text-slate-400" />
    </x-button>
</div>
