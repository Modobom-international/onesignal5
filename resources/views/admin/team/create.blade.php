@extends('layouts.app')

@section('title', __('Create User'))

@section('content')
<div class="min-h-screen bg-background">
    <div class="max-w-[1320px] mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-[28px] font-semibold text-gray-900">{{ __('Tạo phòng ban') }}</h1>
                <p class="mt-2 text-base text-gray-600">{{ __('Thêm phòng ban vào hệ thống') }}</p>
            </div>
            <a href="{{ url('/admin/users') }}"
                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="-ml-1 mr-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Quay lại danh sách') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('users.store')}}" class="divide-y divide-gray-200">
                @csrf
                <div class="p-8 space-y-8">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Tên') }}</label>
                        <div class="mt-1.5">
                            <input type="text"
                                name="name"
                                id="name"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('name'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div class="pt-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-medium text-gray-900">{{ __('Chọn quyền') }}</h3>
                        </div>

                        <div class="mt-4">
                            @foreach($permissions as $permission => $route)
                            <div class="d-flex mt-3">
                                <div>
                                    <input type="checkbox"
                                        id="permission_{{ $permission }}"
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors">
                                </div>

                                <div class="w-full max-w-lg mx-auto accordion-permission">
                                    <div x-data="{ open: false }">
                                        <button type="button" @click.prevent="open = !open" class="w-full text-left px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md">
                                            <label for="permission_{{ $permission }}"
                                                class="ml-3 block text-sm text-gray-600 select-none cursor-pointer">
                                                {{ __(Str::title(str_replace('-', ' ', $permission))) }}
                                            </label>
                                        </button>
                                        @foreach($route as $path)
                                        <div x-show="open" class="px-4 py-2 border-l-4 border-blue-500">
                                            <div class="flex items-center py-2 px-3 rounded-md hover:bg-gray-50 transition-colors">
                                                <input type="checkbox"
                                                    name="permission[{{ $path }}]"
                                                    id="{{ $permission }}_path_{{ $path }}"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors">
                                                <label for="path_{{ $permission }}"
                                                    class="ml-3 block text-sm text-gray-600 select-none cursor-pointer">
                                                    {{ __(Str::title(str_replace('.', ' ', $path->name))) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 rounded-b-lg flex items-center justify-end space-x-3">

                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Tạo') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('input[id^="permission_"]').on('change', function() {
            let permissionId = $(this).attr('id').replace('permission_', '');
            $(`input[id^="${permissionId}_path_"]`).prop('checked', $(this).prop('checked'));
        });

        $('input[id*="_path_"]').on('change', function() {
            handleCheckboxParent();
        });

        handleCheckboxParent();
    });

    function handleCheckboxParent() {
        $('input[id^="permission_"]').each(function() {
            let permissionId = $(this).attr('id').replace('permission_', '');
            let allChecked = $(`input[id^="${permissionId}_path_"]`).length === $(`input[id^="${permissionId}_path_"]:checked`).length;
            $(this).prop('checked', allChecked);
        });
    }
</script>
@endsection