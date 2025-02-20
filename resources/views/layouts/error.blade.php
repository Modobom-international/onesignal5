<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='robots' content='noindex,nofollow' />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.name', 'Modobom') }} - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div x-data="mainState" class="font-sans antialiased" :class="{dark: isDarkMode}" x-cloak>
        <div class="flex flex-col min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <div class="flex items-center justify-center flex-1">
                <div class="text-center">
                    <h1 class="text-9xl font-bold text-gray-900 dark:text-gray-200">@yield('code')</h1>
                    <p class="text-3xl font-semibold mt-6">@yield('title')</p>

                </div>

                <x-footer />
            </div>

            <div class="fixed top-10 right-10">
                <x-button type="button" icon-only variant="secondary" sr-text="Toggle dark mode" x-on:click="toggleTheme">
                    <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
                    <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
                </x-button>
            </div>
        </div>
</body>

</html>