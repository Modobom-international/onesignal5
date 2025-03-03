@props([
    'isActive' => false,
    'title' => '',
    'collapsible' => false,
])

@php
    $isActiveClasses = $isActive
        ? 'text-purple-700 bg-purple-50 border-purple-700'
        : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50 border-transparent hover:border-gray-200';

    $classes =
        'flex items-center gap-1.5 py-2.5 text-sm font-medium transition-all duration-200 ease-in-out relative group cursor-pointer ' .
        $isActiveClasses;

    if ($collapsible) {
        $classes .= ' w-full';
    }
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }"
        @mouseenter="tooltipVisible = true" @mouseleave="tooltipVisible = false">
        <div class="min-w-max flex items-center justify-center"
            :class="{ 'w-12': !isSidebarOpen && !isSidebarHovered, 'px-2': isSidebarOpen || isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="flex-shrink-0 w-5 h-5 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif
        </div>

        {{-- Enhanced Stripe-like Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0" style="position: fixed;"
            class="left-[4.5rem] top-auto bg-gray-900 text-white text-xs font-medium z-[9999] rounded-md px-2 py-1.5 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div
                class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[3px] border-transparent border-r-gray-900">
            </div>
        </div>

        <span class="text-sm overflow-hidden transition-all w-52" x-show="isSidebarOpen || isSidebarHovered"
            x-transition:enter="transition-opacity ease-in-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in-out duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $title }}
        </span>

        <span x-show="isSidebarOpen || isSidebarHovered" aria-hidden="true" class="ml-auto">
            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </span>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }" @mouseenter="tooltipVisible = true"
        @mouseleave="tooltipVisible = false">
        <div class="min-w-max flex items-center justify-center"
            :class="{ 'w-12': !isSidebarOpen && !isSidebarHovered, 'px-3': isSidebarOpen || isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="flex-shrink-0 w-5 h-5 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif
        </div>

        {{-- Enhanced Stripe-like Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0" style="position: fixed;"
            class="left-[4.5rem] top-auto bg-gray-900 text-white text-xs font-medium z-[9999] rounded-md px-2 py-1.5 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div
                class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[3px] border-transparent border-r-gray-900">
            </div>
        </div>

        <span class="text-sm overflow-hidden transition-all w-52 text-nowrap whitespace-nowrap"
            x-show="isSidebarOpen || isSidebarHovered" x-transition:enter="transition-opacity ease-in-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in-out duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            {{ $title }}
        </span>
    </a>
@endif
