<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        {{-- <title>@yield('title', config('app.name', 'Laravel'))</title> --}}


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            
                {{-- <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a> --}}
                 {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-xl">
                        EAS
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-gray-200">EduAdmin</span>
                        <p class="text-xs text-gray-400 leading-none">Educational Administrative Site</p>
                    </div>
                </div>
                
            

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
