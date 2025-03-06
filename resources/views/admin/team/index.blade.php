@extends('layouts.app')

@section('title', __('Phòng ban'))

@section('content')
<div class=" py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Phòng ban') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Quản lý các phòng ban trong công ty') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ route('users.list') }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Nhân viên') }}
            </a>
            <a href="{{ route('team.create') }}"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Thêm phòng ban') }}
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
                    <x-table.head>{{ __('Tên') }}</x-table.head>
                    <x-table.head class="text-right">{{ __('Hành động') }}</x-table.head>
                </x-table.row>
            </x-table.header>

            <x-table.body>
                @foreach($teams as $team)
                <x-table.row>
                    <x-table.cell>
                        <div class="flex items-center">
                            {{ $team->name }}
                        </div>
                    </x-table.cell>
                    <x-table.cell class="text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('team.edit', $team->id) }}"
                                class="text-gray-400 hover:text-gray-500"
                                title="{{ __('Sửa') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="{{ route('team.delete', $team->id) }}"
                                class="text-gray-400 hover:text-gray-500"
                                title="{{ __('Xóa') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </x-table.cell>
                </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>

        <div class="px-4 py-3 border-t border-gray-200">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection