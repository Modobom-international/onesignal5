<div class="flex items-center justify-between flex-shrink-0 px-3 py-3 border-b border-gray-200">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
        <div class="min-w-max" :class="{ 'pl-1': !isSidebarOpen && !isSidebarHovered }">
            {{-- Show application logo when sidebar is open --}}
            <div x-show="isSidebarOpen || isSidebarHovered"
                x-transition:enter="transition-opacity ease-in-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in-out duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <x-logos.application-logo aria-hidden="true" class="w-8 h-8" />
            </div>

            {{-- Show small logo when sidebar is collapsed --}}
            <div x-show="!isSidebarOpen && !isSidebarHovered"
                x-transition:enter="transition-opacity ease-in-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in-out duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <x-logos.logo class="w-8 h-8" />
            </div>
        </div>


    </a>

    <button type="button" class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-700"
        x-show="isSidebarOpen || isSidebarHovered" x-transition:enter="transition-opacity ease-in-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="isSidebarOpen = !isSidebarOpen">
        <svg x-show="isSidebarOpen" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <svg x-show="!isSidebarOpen" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
        <span class="sr-only">Toggle sidebar</span>
    </button>
</div>
