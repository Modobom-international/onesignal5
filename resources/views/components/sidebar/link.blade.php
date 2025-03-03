@props([
    'isActive' => false,
    'title' => '',
    'collapsible' => false,
])

@php
    $isActiveClasses = $isActive
        ? 'text-purple-700 bg-purple-50 hover:bg-purple-100 border-l-4 border-purple-700'
        : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent';

    $classes =
        'flex items-center gap-3 py-2.5 text-sm font-medium transition-all rounded-none relative group ' .
        $isActiveClasses;

    if ($collapsible) {
        $classes .= ' w-full';
    }
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        <div class="min-w-max"
            :class="{ 'px-4': isSidebarOpen || isSidebarHovered, 'px-2.5': !isSidebarOpen && !isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif
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

        {{-- Tooltip for collapsed state --}}
        <div x-show="!isSidebarOpen && !isSidebarHovered" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
            class="absolute left-full rounded-md px-2 py-1 ml-6 bg-gray-900 text-white text-sm invisible opacity-0 -translate-x-3 group-hover:visible group-hover:opacity-100 group-hover:translate-x-0 transition-all z-50">
            {{ $title }}
        </div>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <div class="min-w-max"
            :class="{ 'px-4': isSidebarOpen || isSidebarHovered, 'px-2.5': !isSidebarOpen && !isSidebarHovered }">
            @if ($icon ?? false)
                {{ $icon }}
            @else
                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endif
        </div>

        <span class="text-sm overflow-hidden transition-all w-52" x-show="isSidebarOpen || isSidebarHovered"
            x-transition:enter="transition-opacity ease-in-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in-out duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            {{ $title }}
        </span>

        {{-- Tooltip for collapsed state --}}
        <div x-show="!isSidebarOpen && !isSidebarHovered" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
            class="absolute left-full rounded-md px-2 py-1 ml-6 bg-gray-900 text-white text-sm invisible opacity-0 -translate-x-3 group-hover:visible group-hover:opacity-100 group-hover:translate-x-0 transition-all z-50">
            {{ $title }}
        </div>
    </a>
@endif
