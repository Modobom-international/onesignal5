@extends('layouts.app')

@section('title', __('Create Permission'))

@section('content')
<div class="py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Create New Permission') }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ __('Add a new permission to the system') }}</p>
        </div>
        <div>
            <a href="{{ url('/admin/permissions') }}">
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
        <form method="POST" action="{{ route('permissions.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Permission Name') }}</label>
                <select name="name" id="device-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option selected disabled>{{ __('Choose permission') }}</option>
                    <option value="check-log-count-data">{{ __('Check Log and Count report') }}</option>
                    <option value="manager-file">{{ __('Manager file') }}</option>
                    <option value="manager-push-system">{{ __('Manager PushSystem') }}</option>
                </select>
                @if ($errors->has('name'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <input value="web" type="hidden" name="guard_name">

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Save Permission') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
