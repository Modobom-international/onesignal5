<nav class="flex-1 overflow-y-auto  bg-white dark:!bg-[#0d1117] transition-all duration-300 ease-in-out mt-2"
    :class="{ 'px-2 py-1': !isSidebarOpen && !isSidebarHovered, 'px-2 py-1': isSidebarOpen || isSidebarHovered }">
    <div class="space-y-2">
        {{-- Dashboard --}}
        <x-sidebar.link title="{{ __('Bảng điều khiển') }}" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        {{-- Users Tracking --}}
        <x-sidebar.link title="{{ __('Theo dõi người dùng') }}" href="{{ url('/admin/users-tracking') }}" :isActive="request()->routeIs('viewUsersTracking')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                </svg>
            </x-slot>
        </x-sidebar.link>

        {{-- Log Behavior --}}
        <x-sidebar.link title="{{ __('Nhật ký hành vi') }}" href="{{ url('/admin/log-behavior') }}" :isActive="request()->routeIs('viewLogBehavior')">
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
        <x-sidebar.link title="{{ __('Mã nguồn HTML') }}" href="{{ url('/admin/html-source') }}" :isActive="request()->routeIs('listHtmlSource')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                </svg>
            </x-slot>
        </x-sidebar.link>
        @endif

        @if (auth()->user()->hasRole('super-admin|user-ads'))
        {{-- Domain --}}
        <x-sidebar.link title="{{ __('Tên miền') }}" href="{{ url('/admin/list-domain') }}" :isActive="request()->routeIs('listDomain')">
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
        <x-sidebar.link title="{{ __('Hệ thống đẩy') }}" href="{{ url('/admin/push-system') }}" :isActive="request()->routeIs('listPushSystem')">
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
        <x-sidebar.link title="{{ __('Người dùng') }}" href="{{ url('/admin/users') }}" :isActive="request()->routeIs('list.users')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </x-slot>
        </x-sidebar.link>
        @endif

        {{-- Human Resources --}}
        <x-sidebar.link title="{{ __('Nhân viên') }}" href="{{ url('/admin/employee') }}" :isActive="request()->routeIs('list.employee')">
            <x-slot name="icon">
                <svg class="h-5 w-5 text-gray-500 transition-colors duration-200 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
            </x-slot>
        </x-sidebar.link>
    </div>
</nav>
