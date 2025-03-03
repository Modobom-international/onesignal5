@props([
    'isActive' => false,
    'title' => '',
    'collapsible' => false,
])

@php
    $isActiveClasses = $isActive
        ? 'bg-gray-200/80 text-gray-900 dark:bg-gray-700/50 dark:text-white font-medium'
        : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700/30 dark:hover:text-white';

    $classes = 'flex items-center py-2 transition-all duration-200 ease-in-out relative cursor-pointer rounded-lg ' . $isActiveClasses;

    if ($collapsible) {
        $classes .= ' w-full';
    }
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }"
        @mouseenter="tooltipVisible = true" @mouseleave="tooltipVisible = false">
        <div class="flex items-center w-full"
            :class="{ 'justify-center px-2': !isSidebarOpen && !isSidebarHovered, 'px-3 gap-3': isSidebarOpen || isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif

            <span class="overflow-hidden transition-all" x-show="isSidebarOpen || isSidebarHovered"
                x-transition:enter="transition-opacity ease-in-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in-out duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                {{ $title }}
            </span>

            @if($collapsible)
                <span x-show="isSidebarOpen || isSidebarHovered" aria-hidden="true" class="ml-auto">
                    <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" :class="{ 'rotate-180': open }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </span>
            @endif
        </div>

        {{-- Enhanced Stripe-like Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            style="position: fixed;"
            class="left-[3.75rem] top-auto bg-gray-800 text-white text-xs font-medium z-[9999] rounded-md px-2 py-1.5 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[6px] border-transparent border-r-gray-800">
            </div>
        </div>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }"
        @mouseenter="tooltipVisible = true" @mouseleave="tooltipVisible = false">
        <div class="flex items-center w-full"
            :class="{ 'justify-center px-2': !isSidebarOpen && !isSidebarHovered, 'px-3 gap-3': isSidebarOpen || isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif

            <span class="overflow-hidden transition-all" x-show="isSidebarOpen || isSidebarHovered"
                x-transition:enter="transition-opacity ease-in-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in-out duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                {{ $title }}
            </span>
        </div>

        {{-- Enhanced Stripe-like Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            style="position: fixed;"
            class="left-[3.75rem] top-auto bg-gray-800 text-white text-xs font-medium z-[9999] rounded-md px-2 py-1.5 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[6px] border-transparent border-r-gray-800">
            </div>
        </div>
    </a>
@endif
