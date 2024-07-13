<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('scripts')

    <style>
        /* Navigation Bar Styles */
        .nav-bar {
            position: fixed;
            left: 0;
            top: 0;
            width: 200px;
            height: 100%;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .nav-bar ul {
            list-style-type: none;
            padding: 0;
        }
        .nav-bar li {
            padding: 8px;
            background-color: #ffffff;
            margin-bottom: 4px;
            border-radius: 4px;
        }
        .nav-bar li a {
            text-decoration: none;
            color: #000;
            display: block;
        }
        .sub-menu {
            display: none;
            padding-left: 20px;
        }
        .sub-menu li {
            background-color: #e9ecef;
        }

        /* Content Styles */
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        /* Override any Tailwind CSS classes */
        .bg-gray-100 {
            background-color: #fff !important;
        }
        .dark\:bg-gray-900 {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @unless (Route::currentRouteName() === 'modules.student.quizzes.show')
            @include('layouts.left-nav-bar') <!-- Custom navigation bar -->
            @include('layouts.navigation') <!-- Breeze navigation -->
        @endunless

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="main-content">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
