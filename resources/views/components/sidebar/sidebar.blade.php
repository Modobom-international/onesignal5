<x-sidebar.overlay />

<div class="flex">
    <aside
        class="fixed inset-y-0 z-20 flex flex-col py-4 bg-white border-r border-gray-200 font-sans transition-all duration-300 mt-7"
        :class="{
            'w-64': isSidebarOpen,
            'w-16 md:w-16': !isSidebarOpen,
            'translate-x-0': isSidebarOpen,
            '-translate-x-full md:translate-x-0': !isSidebarOpen
        }"
        @click.outside="window.innerWidth < 768 ? isSidebarOpen = false : null">
        <x-sidebar.content />
        <x-sidebar.footer />
    </aside>

    <!-- Toggle Button -->
    <div class="fixed z-30 transform -translate-y-1/2"
        :class="{
            'left-64': isSidebarOpen,
            'left-16': !isSidebarOpen
        }"
        style="top: 50%;">
        <button type="button" class="group relative flex items-center justify-center w-6 h-12 -mr-px focus:outline-none"
            x-on:click="isSidebarOpen = !isSidebarOpen">
            <!-- Default State (Line) -->
            <div class="w-px h-8 bg-gray-300 group-hover:hidden"></div>

            <!-- Hover State (Arrow Button) -->
            <div
                class="hidden group-hover:flex items-center justify-center absolute inset-0 bg-gray-50 border-y border-r border-gray-200 rounded-r">
                <!-- Arrow Icon -->
                <svg x-show="isSidebarOpen" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <svg x-show="!isSidebarOpen" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

                <!-- Tooltip -->
                <div
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded whitespace-nowrap hidden group-hover:block">
                    <span x-text="isSidebarOpen ? 'Collapse sidebar' : 'Expand sidebar'"></span>
                </div>
            </div>
        </button>
    </div>
</div>
