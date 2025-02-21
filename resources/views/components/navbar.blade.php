<nav aria-label="secondary" x-data="{ open: false }" class="sticky top-0 z-10 flex items-center justify-between py-2 transition-transform duration-500 background-white dark:bg-dark-eval-1" :class="{'-translate-y-full': scrollingDown, 'translate-y-0': scrollingUp,}">
    <div class="flex items-center gap-3">
        <x-button type="button" class="md:hidden" icon-only variant="secondary" sr-text="Toggle dark mode" x-on:click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>
    </div>

    <div class="flex items-center gap-3">
        <x-button type="button" class="hidden md:inline-flex position-relative" data-bs-toggle="dropdown" aria-expanded="false" icon-only variant="secondary" onclick="displayNotification()">
            <x-icons.bell class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            <div id="bell-notification" class="hide">
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle new-notification"></span>
            </div>

        </x-button>

        <ul class="dropdown-menu" id="dropdown-notification" data-popper-placement="bottom-end">
            @if(count($notificationSystem) > 0)
            @foreach($notificationSystem as $notification)
            @if($notification->status_read == 0)
            <li class="background-grey" id="{{ $notification->id->__toString() }}"><a class="dropdown-item">{{ $notification->message }}</a></li>
            @else
            <li><a class="dropdown-item">{{ $notification->message }}</a></li>
            @endif
            @endforeach

            @if(count($notificationSystem) == 4)
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Read more</a></li>
            @endif

            @else
            <li><a class="dropdown-item">{{ __('Không có thông báo nào!') }}</a></li>
            @endif
        </ul>

        <x-button type="button" class="hidden md:inline-flex" icon-only variant="secondary" sr-text="Toggle dark mode" x-on:click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link
                    :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<div class="fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1" :class="{ 'translate-y-full': scrollingDown, 'translate-y-0': scrollingUp, }">
    <x-button type="button" icon-only variant="secondary" sr-text="Search">
        <x-heroicon-o-search aria-hidden="true" class="w-6 h-6" />
    </x-button>

    <a href="{{ route('dashboard') }}">
        <x-application-logo aria-hidden="true" class="w-10 h-10" />
        <span class="sr-only">Dashboard</span>
    </a>

    <x-button type="button" icon-only variant="secondary" sr-text="Open main menu" x-on:click="isSidebarOpen = !isSidebarOpen">
        <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
        <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
    </x-button>
</div>