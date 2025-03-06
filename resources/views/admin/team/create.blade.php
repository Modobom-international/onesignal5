@extends('layouts.app')

@section('title', __('Create Team'))

@section('content')
<div class="">
    <div class=" py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Tạo phòng ban') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Thêm phòng ban vào hệ thống') }}</p>
            </div>
            <a href="{{ url('/admin/users') }}"
                class="group inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                <svg class="mr-2 h-4 w-4 text-gray-500 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Quay lại danh sách') }}
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form method="POST" action="{{ route('team.store')}}" class="divide-y divide-gray-200">
                @csrf
                <div class="p-8">
                    <!-- Team Name Section -->
                    <div class="max-w-2xl">
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Tên phòng ban') }}</label>
                        <div class="mt-2">
                            <input type="text"
                                name="name"
                                id="name"
                                class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-all duration-200"
                                placeholder="{{ __('Nhập tên phòng ban') }}"
                                autocomplete="off">
                        </div>
                        @if ($errors->has('name'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Permissions Section -->
                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Phân quyền truy cập') }}</h3>

                        <div class="space-y-6">
                            @foreach($permissions as $permission => $route)
                            <div class="bg-gray-50 rounded-lg overflow-hidden">
                                <div x-data="{ open: true }" class="border border-gray-200 rounded-lg">
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
                                                    id="{{ $permission }}_path_{{ $path }}"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors">
                                                <label for="{{ $permission }}_path_{{ $path }}"
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

                <div class="px-8 py-4 bg-gray-50 flex items-center justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('Tạo phòng ban') }}
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
        // Enhanced checkbox interactions
        $('input[id^="permission_"]').on('change', function() {
            let permissionId = $(this).attr('id').replace('permission_', '');
            let isChecked = $(this).prop('checked');

            // Animate checkbox changes
            $(`input[id^="${permissionId}_path_"]`).each(function(index) {
                setTimeout(() => {
                    $(this).prop('checked', isChecked);
                }, index * 50); // Stagger the animation
            });
        });

        $('input[id*="_path_"]').on('change', function() {
            handleCheckboxParent();
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
