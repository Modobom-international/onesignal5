@props([
    'isActive' => false,
    'title' => '',
    'collapsible' => false,
])

@php
    $isActiveClasses = $isActive
        ? 'bg-gray-200/60 text-gray-900 dark:bg-gray-700/40 dark:text-white'
        : 'text-gray-600 hover:bg-gray-100/60 dark:text-gray-400 dark:hover:bg-gray-700/30 dark:hover:text-gray-300';

    $classes =
        'flex items-center text-nowrap whitespace-nowrap transition-colors duration-150 ease-in-out relative cursor-pointer rounded-[3px] ' .
        $isActiveClasses;
    $classes .= ' ' . (!$collapsible ? 'w-full' : '');
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }"
        @mouseenter="tooltipVisible = true" @mouseleave="tooltipVisible = false"
        :class="{ 'my-1': !isSidebarOpen && !isSidebarHovered, 'my-[2px]': isSidebarOpen || isSidebarHovered }">
        <div class="flex items-center w-full"
            :class="{
                'justify-center p-2': !isSidebarOpen && !isSidebarHovered,
                'px-3 py-2 gap-3': isSidebarOpen || isSidebarHovered
            }">
            @if ($icon ?? false)
                <div class="flex items-center justify-center w-5 h-5">
                    {{ $icon }}
                </div>
            @else
                <div class="flex items-center justify-center w-5 h-5">
                    <svg class="h-4 w-4 text-gray-400 dark:text-gray-500 shrink-0 transition-transform duration-200 ease-in-out"
                        :class="{ 'transform-gpu': !isSidebarOpen && !isSidebarHovered }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            @endif

            <span class="overflow-hidden text-[13px]"
                :class="{
                    'w-0 opacity-0': !isSidebarOpen && !isSidebarHovered,
                    'w-auto opacity-100': isSidebarOpen || isSidebarHovered
                }">
                {{ $title }}
            </span>

            @if ($collapsible)
                <span aria-hidden="true" class="ml-auto"
                    :class="{
                        'w-0 opacity-0': !isSidebarOpen && !isSidebarHovered,
                        'w-auto opacity-100': isSidebarOpen || isSidebarHovered
                    }">
                    <svg class="h-3.5 w-3.5 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                        :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </span>
            @endif
        </div>

        {{-- Notion-style Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition-all duration-150 ease-out" x-transition:enter-start="opacity-0 translate-x-1"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-150 ease-in"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-1"
            style="position: fixed;"
            class="left-[3rem] top-auto bg-gray-700/95 dark:bg-gray-800/95 text-white text-xs z-[9999] rounded-md px-2 py-1 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div
                class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[4px] border-transparent border-r-gray-700/95 dark:border-r-gray-800/95">
            </div>
        </div>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }} x-data="{ tooltipVisible: false }" @mouseenter="tooltipVisible = true"
        @mouseleave="tooltipVisible = false"
        :class="{ 'my-1': !isSidebarOpen && !isSidebarHovered, 'my-[2px]': isSidebarOpen || isSidebarHovered }">
        <div class="flex items-center w-full"
            :class="{
                'justify-center p-2': !isSidebarOpen && !isSidebarHovered,
                'px-3 py-2 gap-3': isSidebarOpen || isSidebarHovered
            }">
            @if ($icon ?? false)
                <div class="flex items-center justify-center w-5 h-5">
                    {{ $icon }}
                </div>
            @else
                <div class="flex items-center justify-center w-5 h-5">
                    <svg class="h-4 w-4 text-gray-400 dark:text-gray-500 shrink-0 transition-transform duration-200 ease-in-out"
                        :class="{ 'transform-gpu': !isSidebarOpen && !isSidebarHovered }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            @endif

            <span class="overflow-hidden text-[13px]"
                :class="{
                    'w-0 opacity-0': !isSidebarOpen && !isSidebarHovered,
                    'w-auto opacity-100': isSidebarOpen || isSidebarHovered
                }">
                {{ $title }}
            </span>
        </div>

        {{-- Notion-style Tooltip for collapsed state --}}
        <div x-cloak x-show="!isSidebarOpen && !isSidebarHovered && tooltipVisible"
            x-transition:enter="transition-all duration-150 ease-out" x-transition:enter-start="opacity-0 translate-x-1"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-150 ease-in"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-1"
            style="position: fixed;"
            class="left-[3rem] top-auto ml-3 bg-gray-700/95 dark:bg-gray-800/95 text-white text-xs z-[9999] rounded-md px-2 py-1 shadow-lg whitespace-nowrap">
            {{ $title }}
            <div
                class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-[4px] border-transparent border-r-gray-700/95 dark:border-r-gray-800/95">
            </div>
        </div>
    </a>
@endif
