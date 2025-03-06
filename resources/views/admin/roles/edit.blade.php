@extends('layouts.app')

@section('title', __('Edit Role'))

@section('styles')
<style>
    .table-role {
        width: 100%;
        height: 500px;
        overflow: auto;
    }
</style>
@endsection

@section('content')
<div class="py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Edit Role') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Update role details and permissions') }}</p>
        </div>
        <div>
            <a href="{{ url('/admin/roles') }}">
                <button type="button" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back') }}
                </button>
            </a>
        </div>
    </div>

    <div class="mt-8">
        <form method="POST" action="{{ route('roles.update', $role->id) }}" class="space-y-6">
            @method('patch')
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Role Name') }}</label>
                <select name="name" id="device-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option selected disabled>{{ __('Choose role') }}</option>
                    <option value="{{ $role->name }}" {{ $role->name == $role->name ? 'selected' : '' }}>{{ __(Str::title(str_replace('-', ' ', $role->name))) }}</option>
                    <option value="user-ads">{{ __('User Ads') }}</option>
                    <option value="super-admin">{{ __('Super admin') }}</option>
                    <option value="manager-file">{{ __('Manager file') }}</option>
                    <option value="manager-push-system">{{ __('Manager PushSystem') }}</option>
                </select>
                @if ($errors->has('name'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="mt-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Assign Permissions') }}</h2>
                    <div class="relative rounded-md shadow-sm w-64">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="text" id="myInput" onkeyup="myFunction()"
                            class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="{{ __('Search permissions...') }}">
                    </div>
                </div>

                <div class="mt-4 max-h-[32rem] overflow-y-auto rounded-lg border border-gray-200">
                    <table id="myTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[20%]">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="all_permission"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2">{{ __('Check all') }}</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Permission Name') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($permissions as $permission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="permission[{{ $permission->name }}]"
                                            value="{{ $permission->name }}"
                                            class="permission h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        <input type="hidden" name="guard_name" value="{{ $permission->guard_name }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ __(Str::title(str_replace('-', ' ', $permission->name))) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Update Role') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('[name="all_permission"]').on('click', function() {
            if ($(this).is(':checked')) {
                $.each($('.permission'), function() {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($('.permission'), function() {
                    $(this).prop('checked', false);
                });
            }
        });
    });

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection
