<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Desa Suruh</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white antialiased">

        {{-- Panggil Navbar --}}
        @include('layouts.navbar')

        {{-- Main Content --}}
        <main>
            @include('landing.partials._hero')
            @include('landing.partials._services')
            @include('landing.partials._news')
        </main>
        
        
        @include('landing.partials._footer')

    </body>
</html>