<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin | SIMDES</title>
    
    <link rel="icon" href="{{ asset('admin-assets/images/favicon.svg') }}">
    <link href="{{ asset('admin-assets/css/style.css') }}" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
>

    <div class="flex h-screen overflow-hidden">

        {{-- Ini adalah path yang benar sesuai struktur baru --}}
        @include('admin.partials._sidebar')

        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            {{-- Ini adalah path yang benar sesuai struktur baru --}}
            @include('admin.partials._header')

            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    
                    @yield('content')

                </div>
            </main>
            </div>
        </div>
    </body>
</html>