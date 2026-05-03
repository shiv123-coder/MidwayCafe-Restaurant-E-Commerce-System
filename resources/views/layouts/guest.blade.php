<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $enablePreloader = app()->environment('production') && !in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1'], true);
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @if($enablePreloader)
            <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">
        @endif

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body data-app-env="{{ app()->environment() }}">
        @if($enablePreloader)
            @include('partials.preloader')
        @endif
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        @if($enablePreloader)
            <script src="{{ asset('assets/js/preloader.js') }}"></script>
        @endif
    </body>
</html>
