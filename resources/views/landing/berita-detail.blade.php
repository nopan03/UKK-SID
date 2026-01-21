<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $berita->judul }} - Desa Suruh</title>

    <link rel="shortcut icon" href="{{ asset('img/SDA1.png') }}" type="image/png">

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    {{-- Tailwind / Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-900 bg-gray-50">

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- KONTEN BERITA --}}
    <main class="pt-24 pb-20 min-h-screen">
        <div class="container mx-auto px-5 max-w-4xl">
            
            {{-- Tombol Kembali --}}
            <a href="/#news" class="inline-flex items-center text-green-700 hover:text-green-900 font-medium mb-6 transition">
                <i class="ti ti-arrow-left mr-2"></i> Kembali ke Beranda
            </a>

            {{-- Card Berita Detail --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                
                {{-- Gambar Utama (Besar) --}}
                <div class="relative w-full h-64 md:h-96">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                         alt="{{ $berita->judul }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    
                    {{-- Judul di atas Gambar (Opsional, biar keren) --}}
                    <div class="absolute bottom-0 left-0 p-6 md:p-8 text-white">
                        <div class="flex items-center text-sm mb-2 opacity-90">
                            <i class="ti ti-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                        </div>
                        <h1 class="text-2xl md:text-4xl font-bold leading-tight shadow-sm">
                            {{ $berita->judul }}
                        </h1>
                    </div>
                </div>

                {{-- Isi Konten --}}
                <div class="p-6 md:p-10">
                    <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {{-- Menampilkan isi berita dengan format paragraf (nl2br) --}}
                        {!! nl2br(e($berita->isi)) !!}
                    </article>

                    <hr class="my-8 border-gray-200">

                    {{-- Footer Berita --}}
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Penulis: Administrator Desa </span>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    @include('landing.partials._footer')

</body>
</html>