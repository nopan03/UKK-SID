<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- JUDUL TAB BROWSER --}}
    <title>
        @if(isset($title))
            {{ $title }} - Desa Suruh
        @else
            {{ trim($__env->yieldContent('title', 'Desa Suruh')) }}
        @endif
    </title>

    {{-- 🔥 ICON SIDOARJO (Sesuai lokasi file Mas: img/SDA1.png) --}}
    <link rel="shortcut icon" href="{{ asset('img/SDA1.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/SDA1.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>

<body class="bg-white antialiased">

    @include('layouts.navbar')

    <main>
        {{ $slot ?? '' }}

        @yield('content')
    </main>

    @include('landing.partials._footer')

    @stack('scripts')
</body>
</html>