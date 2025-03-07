@extends('layouts.app')

@section('title', __('Tạo nhân viên'))

@section('content')
<div class="min-h-screen bg-background">
    <div class="max-w-[1320px] mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-[28px] font-semibold text-gray-900">{{ __('Tạo nhân viên') }}</h1>
                <p class="mt-2 text-base text-gray-600">{{ __('Thêm nhân viên vào hệ thống') }}</p>
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

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Hòm thư') }}</label>
                        <div class="mt-1.5">
                            <input type="email"
                                name="email"
                                id="email"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Mật khẩu') }}</label>
                        <div class="mt-1.5">
                            <input type="password"
                                name="password"
                                id="password"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('password'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Địa chỉ') }}</label>
                        <div class="mt-1.5">
                            <input type="text"
                                name="address"
                                id="address"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('address'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('address') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Số điện thoại') }}</label>
                        <div class="mt-1.5">
                            <input type="text"
                                name="phone_number"
                                id="phone_number"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('phone_number'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('phone_number') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="team" class="block text-sm font-medium text-gray-700">{{ __('Phòng ban') }}</label>
                        <div class="mt-1.5">
                            <select name="team" id="team" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                                @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('team'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('team') }}</p>
                        @endif
                    </div>

                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Phân quyền truy cập') }}</h3>

                        <div class="space-y-6">
                            @foreach($permissions as $permission => $route)
                            <div class="bg-gray-50 rounded-lg overflow-hidden">
                                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                    <div class="flex items-center px-4 py-3">
                                        <input type="checkbox"
                                            id="permission_{{ $permission }}"
                                            class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors">
                                        <label for="permission_{{ $permission }}"
                                            class="ml-3 flex-1 text-sm font-medium text-gray-900">
                                            {{ __(Str::title(str_replace('-', ' ', $permission))) }}
                                        </label>
                                        <button type="button"
                                            @click.prevent="open = !open"
                                            class="ml-2 flex items-center text-sm text-gray-500 hover:text-gray-700">
                                            <span x-show="!open">{{ __('Hiển thị chi tiết') }}</span>
                                            <span x-show="open">{{ __('Ẩn chi tiết') }}</span>
                                            <svg class="ml-1.5 h-4 w-4 transition-transform duration-200"
                                                :class="{'rotate-180': open}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        class="border-t border-gray-200">
                                        @foreach($route as $path)
                                        <div class="px-4 py-3 hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center">
                                                <input type="checkbox"
                                                    name="permissions[{{ $path->id }}]"
                                                    id="{{ $permission }}_path_{{ $path->name }}"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors">
                                                <label for="{{ $permission }}_path_{{ $path->name }}"
                                                    class="ml-3 text-sm text-gray-600">
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
                        {{ __('Tạo nhân viên') }}
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
        var id_default_team = $('#team').val();
        var default_team = '';
        const team_permission = JSON.parse(`<?php echo json_encode($teams) ?>`);

        for (var i in team_permission) {
            if (team_permission[i].id == id_default_team) {
                default_team = team_permission[i];
            }
        }

        if (default_team != '') {
            for (var k in default_team.permissions) {
                let isChecked = true;
                let permissionId = default_team.permissions[k].prefix;

                $(`input[id^="${permissionId}_path_${default_team.permissions[k].name}"]`).prop('checked', isChecked);
            }
        }

        $('input[id^="permission_"]').on('change', function() {
            let permissionId = $(this).attr('id').replace('permission_', '');
            let isChecked = $(this).prop('checked');

            $(`input[id^="${permissionId}_path_"]`).each(function(index) {
                $(this).prop('checked', isChecked);
            });
        });

        $('input[id*="_path_"]').on('change', function() {
            handleCheckboxParent();
        });

        $('#team').on('change', function() {
            let url = `<?php echo route('team.get.permission') ?>`;
            let id = $(this).val();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                }
            }).done(function(result) {
                $(`input[id^="permission_"]`).each(function() {
                    $(this).prop('checked', false);
                    $(this).prop('indeterminate', false);
                });

                $(`input[id*="_path_"]`).each(function() {
                    $(this).prop('checked', false);
                    $(this).prop('indeterminate', false);
                });

                for (var i in result) {
                    let isChecked = true;

                    for (var k in result[i]) {
                        let id = `${i}_path_${result[i][k]}`;
                        $(`input[id^="${i}_path_${result[i][k]}"]`).prop('checked', isChecked);
                    }
                }

                handleCheckboxParent();
            });
        });

        handleCheckboxParent();
    });

    function handleCheckboxParent() {
        $('input[id^="permission_"]').each(function() {
            let permissionId = $(this).attr('id').replace('permission_', '');
            let totalCheckboxes = $(`input[id^="${permissionId}_path_"]`).length;
            let checkedCheckboxes = $(`input[id^="${permissionId}_path_"]:checked`).length;

            $(this).prop('checked', totalCheckboxes === checkedCheckboxes);
            $(this).prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        });
    }
</script>
@endsection