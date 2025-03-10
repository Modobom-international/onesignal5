<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='robots' content='noindex,nofollow' />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.name', 'Modobom') }} - @yield('title')</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="{{ asset('/css/lib/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/lib.css') }}" />

    @yield('styles')

    <style>
        [x-cloak] {
            display: none;
        }

        .form-control {
            padding: 0.375rem 0.75rem !important;
            font-size: 1rem !important;
            line-height: 1.5;
            background-color: var(--bs-body-bg) !important;
            border: 1px solid #ccc !important;
            border-radius: var(--bs-border-radius) !important;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="mainState" :class="{ dark: isDarkMode }" x-on:resize.window="handleWindowResize" x-cloak>
        <div class="min-h-screen text-gray-900 bg-background dark:bg-dark-eval-0 dark:text-gray-200">
            <!-- Fixed Navbar -->
            <div class="fixed top-0 left-0 right-0 z-10">
                <x-navbar />
            </div>

            <!-- Main Layout Container -->
            <div class="flex pt-16"> <!-- pt-16 to offset fixed navbar -->
                <!-- Sidebar -->
                <div class="fixed left-0 h-[calc(100vh-4rem)]"
                    :class="{ 'w-64': isSidebarOpen, 'w-16': !isSidebarOpen }"
                    style="transition-property: width; transition-duration: 150ms;">
                    <x-sidebar.sidebar />
                </div>

                <!-- Main Content -->
                <div class="flex-1 min-h-[calc(100vh-4rem)] flex flex-col"
                    :class="{ 'lg:ml-64': isSidebarOpen, 'md:ml-16': !isSidebarOpen }"
                    style="transition-property: margin; transition-duration: 150ms;">

                    <main class="px-4 sm:px-6 flex-1 container mx-auto">
                        @yield('content')
                    </main>

                    <x-footer />
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript">
        <?php if (session('success')) { ?>
            toastr.success("{{ session('success') }}", "Success");
        <?php } ?>

        <?php if (session('info')) { ?>
            toastr.info("{{ session('info') }}", "Info");
        <?php } ?>

        <?php if (session('warning')) { ?>
            toastr.warning("{{ session('warning') }}", "Warning");
        <?php } ?>

        <?php if (session('error')) { ?>
            toastr.error("{{ session('error') }}", "Error");
        <?php } ?>
    </script>

    <script>
        const users_id = '<?php echo Auth::user()->id; ?>';

        $(document).ready(function() {
            Echo.channel("notification-system").listen("NotificationSystem", (e) => {
                const data = e.data;
                if (users_id == data.users_id) {
                    if ($('#bell-notification').hasClass('hide')) {
                        $('#bell-notification').removeClass('hide');
                    }

                    $("#dropdown-notification").prepend(`<li class="background-grey" id="` + data.id +
                        `"><a class="dropdown-item">` + data.message + `</a></li>`);
                    if ($("#dropdown-notification li").length >= 4) {
                        $("#dropdown-notification").last().remove();
                    }
                }
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
