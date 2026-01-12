@extends('layouts.app')

@section('title', 'Peta & Batas Wilayah')

@section('content')

    {{-- 1. HERO SECTION --}}
    <div class="bg-green-700 py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto px-6 relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Peta & Batas Wilayah</h1>
            <p class="text-lg md:text-xl text-green-100 max-w-2xl mx-auto">
                Mengetahui letak geografis dan batas-batas administratif Desa Suruh.
            </p>
        </div>
        {{-- Hiasan Bawah (Lebih Sejajar/Landai) --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[30px] md:h-[40px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V120H1200V0S600,40,0,0Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 py-12 min-h-screen">
        <div class="container mx-auto px-4 md:px-6">

            {{-- 2. BATAS WILAYAH (Tanpa Judul Besar) --}}
            <div class="mb-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Utara --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-blue-500 text-center hover:shadow-md transition">
                        <h3 class="text-base font-bold text-gray-800 mb-1">Sebelah Utara</h3>
                        <p class="text-gray-600 text-sm">Desa Sukodono</p>
                    </div>
                    {{-- Selatan --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-green-500 text-center hover:shadow-md transition">
                        <h3 class="text-base font-bold text-gray-800 mb-1">Sebelah Selatan</h3>
                        <p class="text-gray-600 text-sm">Desa Pekarungan</p>
                    </div>
                    {{-- Timur --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-yellow-500 text-center hover:shadow-md transition">
                        <h3 class="text-base font-bold text-gray-800 mb-1">Sebelah Timur</h3>
                        <p class="text-gray-600 text-sm">Desa Jumputrejo</p>
                    </div>
                    {{-- Barat --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-red-500 text-center hover:shadow-md transition">
                        <h3 class="text-base font-bold text-gray-800 mb-1">Sebelah Barat</h3>
                        <p class="text-gray-600 text-sm">Desa Pekarungan</p>
                    </div>
                </div>
            </div>

            {{-- 3. PETA DESA --}}
            <div class="bg-white p-4 rounded-2xl shadow border border-gray-200 max-w-5xl mx-auto">
                
                {{-- Container Peta (Lebih Kecil & Ringkas) --}}
                <div class="relative w-full h-[300px] md:h-[400px] rounded-xl overflow-hidden bg-gray-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7913.059431851986!2d112.67732568810679!3d-7.406470281050728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e3b97f525781%3A0x3af07d92cd3f3a9f!2sSuruh%2C%20Kec.%20Sukodono%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1764498120153!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="https://maps.app.goo.gl/J8g8k8z8z8z8z8z8" target="_blank" class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold transition text-xs md:text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka di Google Maps
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection