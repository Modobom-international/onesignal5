<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    @if(auth()->user()->hasRole('super-admin|user-ads|manager-file'))
    <x-sidebar.link title="Log behavior" href="{{ url('/admin/log-behavior') }}" :isActive="request()->routeIs('viewLogBehavior')">
        <x-slot name="icon">
            <x-icons.peid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    
    <x-sidebar.link title="HTML Source" href="{{ url('/admin/html-source') }}" :isActive="request()->routeIs('listHtmlSource')">
        <x-slot name="icon">
            <x-icons.html5 class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endif

    @if(auth()->user()->hasRole('super-admin'))
    <x-sidebar.link title="Push System" href="{{ url('/admin/push-system') }}" :isActive="request()->routeIs('listPushSystem')">
        <x-slot name="icon">
            <x-icons.pushed class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Users" href="{{ url('/admin/users') }}" :isActive="request()->routeIs('list.users')">
        <x-slot name="icon">
            <x-icons.user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endif
</x-perfect-scrollbar>