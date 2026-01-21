<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Desa Suruh - Membangun Bersama</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/SDA1.png') }}" type="image/png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- 🔥 CSS ANIMASI (AOS) --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    {{-- Tailwind / Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Custom untuk Background Sambutan */
        @keyframes colorPulse {
            0% { background-color: #f9fafb; }
            50% { background-color: #f0fdf4; }
            100% { background-color: #f9fafb; }
        }
        .animate-bg-pulse {
            animation: colorPulse 6s infinite ease-in-out;
        }
        
        /* Animasi Zoom Halus Hero */
        @keyframes subtleZoom {
            0% { transform: scale(1.0); }
            100% { transform: scale(1.1); }
        }
        .animate-subtle-zoom {
            animation: subtleZoom 20s infinite alternate ease-in-out;
        }
    </style>
</head>
<body class="antialiased font-sans text-gray-900 bg-white">

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- ============================================================ --}}
    {{-- BAGIAN 1: HERO SECTION                                       --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0">
            <img src="{{ asset('img/Sawah.jpg') }}" alt="Background" 
                 class="w-full h-full object-cover transform scale-110 animate-subtle-zoom">
            <div class="absolute inset-0 bg-black opacity-60"></div>
        </div>

        {{-- Konten --}}
        <div class="relative z-10 container mx-auto px-5">
            <div class="text-center md:-ml-5"> 
                <div class="text-white">
                    <h1 class="text-4xl md:text-6xl font-light leading-tight mb-4" 
                        data-aos="fade-up" data-aos-duration="1000">
                        Selamat Datang di Website
                    </h1>
                    <p class="text-3xl md:text-5xl font-bold mb-2"
                       data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                        Desa Suruh
                    </p>
                    <p class="text-xl md:text-2xl font-medium text-gray-200"
                       data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                        Membangun Desa Bersama Melalui Teknologi
                    </p>
                </div>

                {{-- Menu Ikon --}}
                <div class="mt-16">
                    <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                        <a href="{{ route('surat.index') }}" class="text-center text-white group"
                           data-aos="fade-up" data-aos-delay="600" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-file-text text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold group-hover:text-yellow-400 transition">Administrasi Surat</h3>
                        </a>
                        <a href="{{ route('keluhan.create') }}" class="text-center text-white group"
                           data-aos="fade-up" data-aos-delay="800" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-speakerphone text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold group-hover:text-yellow-400 transition">Lapor Keluhan</h3>
                        </a>
                        <a href="{{ route('infografis.penduduk') }}" class="text-center text-white group"
                           data-aos="fade-up" data-aos-delay="1000" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-chart-pie text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold group-hover:text-yellow-400 transition">Infografis Desa</h3>
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- BAGIAN 2: SAMBUTAN KEPALA DESA                               --}}
    {{-- ============================================================ --}}
    <section id="sambutan" class="py-20 animate-bg-pulse overflow-hidden">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12"
                data-aos="fade-down" data-aos-duration="1000">
                Sambutan Kepala Desa
            </h2>
            
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                {{-- Foto Kades --}}
                <div class="md:col-span-1 relative" 
                     data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                    <div class="absolute inset-0 bg-yellow-400 rounded-lg transform translate-x-3 translate-y-3 z-0 hidden md:block"></div>
                    <img src="{{ asset('img/kades.jpeg') }}" alt="Kades" 
                         class="rounded-lg shadow-xl w-full h-full object-contain relative z-10 mt-4 md:mt-0 transition duration-500 hover:scale-105">
                </div>
                
                {{-- Teks Sambutan --}}
                <div class="md:col-span-2 text-center md:text-left"
                     data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                    <h3 class="text-3xl font-semibold text-green-700 mb-3">Bapak Suwono</h3>
                    <h4 class="text-2xl font-medium text-gray-700 mb-4">Kepala Desa Suruh</h4>
                    <div class="space-y-4 text-gray-600 leading-relaxed text-lg">
                        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
                        <p>Selamat datang di Website Resmi Desa Suruh. Website ini kami bangun sebagai wujud komitmen kami terhadap transparansi informasi publik dan sebagai sarana untuk mempercepat pelayanan kepada seluruh warga.</p>
                        <p>Melalui Sistem Informasi Manajemen Desa (SIMDES) ini, kami berharap dapat menjembatani komunikasi antara pemerintah desa dan masyarakat, serta memudahkan akses terhadap layanan administrasi dan informasi desa. Mari kita bersama-sama membangun Desa Suruh yang lebih maju, cerdas, dan sejahtera.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- BAGIAN 3: BERITA & INFORMASI (YANG SEMPAT HILANG)            --}}
    {{-- ============================================================ --}}
    
    {{-- 🔥 INI DIA YANG DITAMBAHKAN AGAR BERITA MUNCUL 🔥 --}}
    @include('landing.partials._news')


    {{-- FOOTER --}}
    @include('landing.partials._footer')

    {{-- SCRIPT JAVASCRIPT ANIMASI (AOS) --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, 
            duration: 800, 
            offset: 100, 
        });
    </script>
</body>
</html>