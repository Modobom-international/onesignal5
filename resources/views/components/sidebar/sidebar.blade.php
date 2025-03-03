<x-sidebar.overlay />

<aside class="fixed inset-y-0 z-20 flex flex-col bg-white border-r border-gray-200 font-sans transition-all duration-300"
    :class="{
        'w-64': isSidebarOpen || isSidebarHovered,
        'w-16 md:w-16': !isSidebarOpen && !isSidebarHovered,
        'translate-x-0': isSidebarOpen,
        '-translate-x-full md:translate-x-0': !isSidebarOpen
    }"
    @mouseover="handleSidebarHover(true)" @mouseleave="handleSidebarHover(false)" @click.outside="isSidebarOpen = false">
    <x-sidebar.header />
    <x-sidebar.content />
    <x-sidebar.footer />
</aside>
