@extends('layouts.app')

@section('title', __('User Details'))

@section('content')
<div class="min-h-screen bg-background">
    <div class="max-w-[1320px] mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-[28px] font-semibold text-gray-900">{{ __('User Details') }}</h1>
                <p class="mt-2 text-base text-gray-600">{{ __('View user information and roles') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ url('/admin/users') }}"
                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="-ml-1 mr-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to Users') }}
                </a>
                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                   class="inline-flex items-center px-3 py-1.5 border border-transparent bg-indigo-600 rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="-ml-1 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit User') }}
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('User ID') }}</h3>
                        <p class="mt-1 text-base font-mono text-gray-900">{{ $user->id }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('Name') }}</h3>
                        <p class="mt-1 text-base text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('Email') }}</h3>
                        <p class="mt-1 text-base text-gray-900">{{ $user->email }}</p>
                    </div>

                    @if (!empty($user->getRoleNames()))
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('Roles') }}</h3>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($user->getRoleNames() as $rolename)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $rolename }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-base font-medium text-gray-900 mb-4">{{ __('Additional Information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('Created At') }}</h3>
                            <p class="mt-1 text-base text-gray-900">{{ $user->created_at->format('F j, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('Last Updated') }}</h3>
                            <p class="mt-1 text-base text-gray-900">{{ $user->updated_at->format('F j, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
