<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-coreui-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body data-coreui-theme="light">
    <div id="app">
        @include('web.layouts.navigation')
        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')
</body>

</html>
