@extends('layouts.app')

@section('title', __('Roles'))

@section('content')
<div class="py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold ">{{ __('Roles') }}</h1>
            <p class="mt-2 text-sm ">{{ __('Manage roles and their permissions') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ url('/admin/users') }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Users') }}
            </a>
            <a href="{{ url('/admin/permissions') }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Permissions') }}
            </a>
            <a href="{{ url('/admin/roles/create') }}"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add New Role') }}
            </a>
        </div>
    </div>

    <div class="mt-8">
        <div class="py-4 border-b border-gray-200">
            <form method="GET" action="{{ url('/admin/roles') }}" class="max-w-lg flex gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Search roles...') }}">
                    </div>
                </div>
            </form>
        </div>

        <x-table>
            <x-table.header>
                <x-table.row>
                    <x-table.head>{{ __('ID') }}</x-table.head>
                    <x-table.head>{{ __('Name') }}</x-table.head>
                    <x-table.head class="text-right">{{ __('Actions') }}</x-table.head>
                </x-table.row>
            </x-table.header>

            <x-table.body>
                @foreach($roles as $item)
                    <x-table.row>
                        <x-table.cell class="font-mono text-xs">{{ $item->id }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center">

                                <div class="">
                                    <a href="{{ url('/admin/roles', $item->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">{{ __(Str::title(str_replace('-', ' ', $item->name))) }}</a>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell class="text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ url('/admin/roles/' . $item->id) }}"
                                    class="text-gray-400 hover:text-gray-500"
                                    title="{{ __('View Role') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ url('/admin/roles/' . $item->id . '/edit') }}"
                                    class="text-gray-400 hover:text-gray-500"
                                    title="{{ __('Edit Role') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ url('/admin/roles/' . $item->id) }}" style="display:inline" onsubmit="return confirm('{{ __('Confirm delete?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-gray-500" title="{{ __('Delete Role') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>

        <div class="px-4 py-3 border-t border-gray-200">
            {!! $roles->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>
</div>
@endsection
