<nav class="flex-1 overflow-y-auto  bg-white dark:!bg-[#0d1117] transition-all duration-300 ease-in-out mt-2"
    :class="{ 'px-2 py-1': !isSidebarOpen && !isSidebarHovered, 'px-2 py-1': isSidebarOpen || isSidebarHovered }">
    <div class="space-y-2">
        {{-- Dashboard --}}
        <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        {{-- Users Tracking --}}
        <x-sidebar.link title="Users Tracking" href="{{ url('/admin/users-tracking') }}" :isActive="request()->routeIs('viewUsersTracking')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        {{-- Log Behavior --}}
        <x-sidebar.link title="Log Behavior" href="{{ url('/admin/log-behavior') }}" :isActive="request()->routeIs('viewLogBehavior')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75a.75.75 0 000-1.5H10.5a.75.75 0 01-.75-.75V9.75a.75.75 0 00-.75-.75h-.75m0 0c-.376.023-.75.05-1.124.08C6.095 9.26 5.25 10.223 5.25 11.358V19.5a2.25 2.25 0 002.25 2.25h.75a.75.75 0 000-1.5H7.5a.75.75 0 01-.75-.75v-3z" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        @if (auth()->user()->hasRole('super-admin|user-ads|manager-file'))
        {{-- HTML Source --}}
        <x-sidebar.link title="HTML Source" href="{{ url('/admin/html-source') }}" :isActive="request()->routeIs('listHtmlSource')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                </svg>
            </x-slot>
        </x-sidebar.link>
        @endif

        @if (auth()->user()->hasRole('super-admin|user-ads'))
        {{-- Domain --}}
        <x-sidebar.link title="Domain" href="{{ url('/admin/list-domain') }}" :isActive="request()->routeIs('listDomain')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                </svg>
            </x-slot>
        </x-sidebar.link>
        @endif

        @if (auth()->user()->hasRole('super-admin'))
        {{-- Push System --}}
        <x-sidebar.link title="Push System" href="{{ url('/admin/push-system') }}" :isActive="request()->routeIs('listPushSystem')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        {{-- Users --}}
        <x-sidebar.link title="Users" href="{{ url('/admin/users') }}" :isActive="request()->routeIs('list.users')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-slot>
        </x-sidebar.link>
        @endif

        {{-- Human Resources --}}
        <x-sidebar.link title="Nhân viên" href="{{ url('/admin/employee') }}" :isActive="request()->routeIs('list.employee')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-slot>
        </x-sidebar.link>
    </div>
</nav>