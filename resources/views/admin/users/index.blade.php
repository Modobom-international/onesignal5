@extends('layouts.app')

@section('title', __('Users'))

@section('content')
<div class=" py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Users') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Manage user accounts and their roles') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ url('/admin/users/create') }}"
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add New User') }}
            </a>
            <a href="{{ url('/admin/roles') }}"
               class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Roles') }}
            </a>
            <a href="{{ url('/admin/permissions') }}"
               class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Permissions') }}
            </a>
        </div>
    </div>

    <div class="mt-8 ">
        <div class="py-4 border-b border-gray-200">
            <form method="GET" action="{{ url('/admin/users') }}" class="max-w-lg flex gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="{{ __('Search users...') }}">
                    </div>
                </div>
            </form>
        </div>

        <x-table>
            <x-table.header>
                <x-table.row>
                    <x-table.head>{{ __('ID') }}</x-table.head>
                    <x-table.head>{{ __('Name') }}</x-table.head>
                    <x-table.head>{{ __('Email') }}</x-table.head>
                    <x-table.head>{{ __('Roles') }}</x-table.head>
                    <x-table.head class="text-right">{{ __('Actions') }}</x-table.head>
                </x-table.row>
            </x-table.header>

            <x-table.body>
                @foreach($users as $item)
                    <x-table.row>
                        <x-table.cell class="font-mono text-xs">{{ $item->id }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">{{ substr($item->name, 0, 2) }}</span>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ url('/admin/users', $item->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">{{ $item->name }}</a>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>{{ $item->email }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex flex-wrap gap-1">
                                @if (!empty($item->getRoleNames()))
                                    @foreach ($item->getRoleNames() as $rolename)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $rolename }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </x-table.cell>
                        <x-table.cell class="text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ url('/admin/users/' . $item->id) }}"
                                   class="text-gray-400 hover:text-gray-500"
                                   title="{{ __('View User') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ url('/admin/users/' . $item->id . '/edit') }}"
                                   class="text-gray-400 hover:text-gray-500"
                                   title="{{ __('Edit User') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @if(!auth()->user()->hasRole('super-admin'))
                                    <a href="{{ route('changePasswordUser', $item->id) }}"
                                       class="text-gray-400 hover:text-gray-500"
                                       title="{{ __('Change Password') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>

        <div class="px-4 py-3 border-t border-gray-200">
            {!! $users->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>
</div>
@endsection
