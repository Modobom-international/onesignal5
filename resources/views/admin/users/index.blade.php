@extends('layouts.app')

@section('title', __('Nhân viên'))

@section('content')
<div class=" py-8">
    <div class="sm:flex sm:items-center sm:justify-between border-border border-b pb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Nhân viên') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Quản lý nhân viên và quyền của họ') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
            <a href="{{ url('/admin/team') }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                {{ __('Phòng ban') }}
            </a>
            <a href="{{ url('/admin/users/create') }}"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Thêm nhân viên') }}
            </a>
        </div>
    </div>

    <div class="mt-8 ">
        <div class="py-4 border-b border-gray-200">
            <form method="GET" action="{{ route('users.list') }}" class="max-w-lg flex gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Tìm kiếm nhân viên...') }}">
                    </div>
                </div>
            </form>
        </div>

        <x-table>
            <x-table.header>
                <x-table.row>
                    <x-table.head>{{ __('ID') }}</x-table.head>
                    <x-table.head>{{ __('Tên') }}</x-table.head>
                    <x-table.head>{{ __('Hòm thư') }}</x-table.head>
                    <x-table.head>{{ __('Đội') }}</x-table.head>
                    <x-table.head class="text-right">{{ __('Hành động') }}</x-table.head>
                </x-table.row>
            </x-table.header>

            <x-table.body>
                @foreach($users as $user)
                <x-table.row>
                    <x-table.cell class="font-mono text-xs">{{ $user->id }}</x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600">{{ __(mb_substr($user->name, 0, 2, 'UTF-8')) }}</span>
                            </div>
                            <div class="ml-4">
                                {{ $user->name }}
                            </div>

                        </div>
                    </x-table.cell>
                    <x-table.cell>{{ $user->email }}</x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-wrap gap-1">

                        </div>
                    </x-table.cell>
                    <x-table.cell class="text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="text-gray-400 hover:text-gray-500"
                                title="{{ __('Sửa nhân viên') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="{{ route('users.delete', $user->id) }}"
                                class="text-gray-400 hover:text-gray-500"
                                title="{{ __('Xóa nhân viên') }}">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </x-table.cell>
                </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>

        <div class="px-4 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
