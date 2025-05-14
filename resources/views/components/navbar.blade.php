<nav aria-label="primary" x-data="{ open: false, notificationOpen: false }"
    class="sticky top-0 left-0 right-0 backdrop-blur flex-none transition-colors duration-300 border-b border-slate-900/10 dark:border-[#30363d] bg-white/95 dark:bg-[#0d1117]">
    <div class="h-14 flex items-center justify-between px-4 mx-4">
        <div class="flex items-center gap-3">
            <x-button type="button" icon-only variant="ghost" sr-text="Open main menu" x-on:click="toggleSidebar()"
                class="md:hidden h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200">
                <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true"
                    class="w-4 h-4 " />
                <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true"
                    class="w-4 h-4 " />
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
            <x-button type="button" icon-only variant="ghost" sr-text="Search"
                class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200">
                <x-heroicon-o-search aria-hidden="true" class="w-4 h-4 " />
            </x-button>

            <!-- Theme Toggle -->
            <x-button type="button"
                class="h-8 w-8 justify-center hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200"
                icon-only variant="ghost" sr-text="Toggle dark mode" x-on:click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true"
                    class="w-4 h-4 " />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true"
                    class="w-4 h-4 " />
            </x-button>

            <div x-data="{ open: false }"
                @mouseenter="open = true"
                @mouseleave="open = false"
                class="relative ">
                <button class="h-8 px-2 flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200 rounded-md">
                    @if(app()->getLocale() === 'en')
                        <x-flag.en class="w-5 h-5" />
                    @else
                        <x-flag.vn class="w-5 h-5" />
                    @endif
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-44 bg-white dark:!bg-[#161b22] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-[#30363d] py-1 focus:outline-none"
                    style="z-index: 50;">
                    <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                        class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-[#c9d1d9] hover:bg-slate-50 dark:hover:bg-[#1f242c] transition-colors duration-200">
                        <x-flag.en class="w-5 h-5" />
                        <span class="font-medium ml-3">English</span>
                        @if(app()->getLocale() === 'en')
                            <x-heroicon-o-check class="w-4 h-4 ml-2 text-slate-500 dark:text-[#8b949e]" />
                        @endif
                    </a>
                    <a href="{{ route('lang.switch', ['locale' => 'vi']) }}"
                        class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-[#c9d1d9] hover:bg-slate-50 dark:hover:bg-[#1f242c] transition-colors duration-200">
                        <x-flag.vn class="w-5 h-5" />
                        <span class="font-medium ml-3">Tiếng Việt</span>
                        @if(app()->getLocale() === 'vi')
                            <x-heroicon-o-check class="w-4 h-4 ml-2 text-slate-500 dark:text-[#8b949e]" />
                        @endif
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-2 h-8 pl-2 pr-1 text-sm font-medium rounded-full hover:bg-slate-100 dark:hover:bg-[#161b22] transition-colors duration-200 border border-transparent hover:border-slate-200 dark:hover:border-[#30363d]">
                        <span class="h-6 w-6 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span class="text-xs font-medium text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </span>
                        <span class="hidden sm:block text-sm text-slate-700 dark:text-[#c9d1d9]">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="w-4 h-4 text-slate-400 dark:text-[#8b949e]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content" >
                    <div class="p-1">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 rounded-md hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-slate-500 dark:text-slate-400" />
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>

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
