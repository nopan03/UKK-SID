@extends('layouts.app')

@section('title', 'Struktur Organisasi & Aparatur Desa')

@section('content')

    {{-- HERO SECTION (SESUAI DENGAN PETA-DESA) --}}
    <div class="bg-green-700 py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto px-6 relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Struktur Organisasi
            </h1>
            <p class="text-lg md:text-xl text-green-100 max-w-2xl mx-auto">
                Mengenal lebih dekat jajaran pemerintahan Desa Suruh yang siap melayani masyarakat dengan sepenuh hati.
            </p>
        </div>
        {{-- Hiasan Bawah --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[30px] md:h-[40px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V120H1200V0S600,40,0,0Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    {{-- FOTO KEPALA DESA TERPISAH --}}
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6 mb-16">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">

                {{-- Foto --}}
                <div class="relative w-full aspect-[3/4] overflow-hidden bg-gray-100">
                    <img src="{{ asset('img/kades.jpeg') }}"
                         alt="Kepala Desa - Bpk. Sutrisno"
                         class="w-full h-full object-cover object-top">
                </div>

                {{-- Info Kepala Desa --}}
                <div class="p-6 text-center">

                    <span class="bg-yellow-400 text-green-900 text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wide border-2 border-white shadow mb-3 inline-block">
                        Kepala Desa
                    </span>

                    <h3 class="text-xl font-bold text-gray-800 mt-3 mb-3">
                        Bpk. Suwono
                    </h3>

                    <p class="text-gray-600 italic">
                        "Melayani dengan hati, membangun dengan aksi."
                    </p>
                </div>

            </div>
        </div>
    </div>

{{-- SLIDER APARATUR DESA (Revisi: Hapus Garis Atas & Infinite Loop) --}}
    <div class="bg-gray-50 py-10"> {{-- HAPUS class 'border-t border-gray-200' di sini --}}
        <div class="container mx-auto px-4 md:px-6">

            {{-- JUDUL SEKSI --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Perangkat Desa</h2>
                {{-- Garis hiasan kecil di bawah teks (jika ingin dihapus juga, hapus div di bawah ini) --}}
                <div class="w-24 h-1 bg-green-600 mx-auto mt-2"></div>
                <p class="text-gray-600 mt-3">Rekan kerja yang solid dalam membangun desa.</p>
            </div>

            <div x-data="{
                    activeSlide: 0,
                    itemsPerSlide: 1,
                    slides: [
                        {
                            name: 'Rohim S.Sos',
                            position: 'Sekretaris Desa',
                            img: 'Sekretaris Desa  Rohim S.Sos.jpeg',
                            quote: 'Tertib administrasi kunci kemajuan desa.'
                        },
                        {
                            name: 'Buchori',
                            position: 'Kaur Pemerintahan',
                            img: 'Kepala Urusan Pemerintahan  Buchori.jpeg',
                            quote: 'Menjaga ketertiban dan keamanan warga.'
                        },
                        {
                            name: 'Dewi Siam Apriliani S.E',
                            position: 'Kaur Keuangan',
                            img: 'Kepala Urusan Keuangan  Dewi Siam Apriliani S.E.jpeg',
                            quote: 'Transparansi anggaran untuk kesejahteraan.'
                        },
                        {
                            name: 'Ratna Arianti S.Kep.Ners',
                            position: 'Kaur Tata Usaha & Umum',
                            img: 'Kepala Urusan Tata Usaha dan Umum  Ratna Arianti S.Kep.Ners.jpeg',
                            quote: 'Pelayanan administrasi yang rapi dan cepat.'
                        },
                        {
                            name: 'Suhudi',
                            position: 'Kasi Pelayanan',
                            img: 'Kasi Pelayanan  Suhudi.jpeg',
                            quote: 'Melayani kebutuhan warga dengan prima.'
                        }
                    ],
                    init() {
                        this.updateItemsPerSlide();
                        window.addEventListener('resize', () => this.updateItemsPerSlide());
                    },
                    updateItemsPerSlide() {
                        if (window.innerWidth >= 1024) this.itemsPerSlide = 3; 
                        else if (window.innerWidth >= 768) this.itemsPerSlide = 2; 
                        else this.itemsPerSlide = 1; 
                        
                        // Reset slide jika overflow (opsional, agar tidak error saat resize)
                        if (this.activeSlide > this.slides.length - this.itemsPerSlide) {
                            this.activeSlide = 0;
                        }
                    },
                    next() {
                        // LOGIKA LOOPING (INFINITE)
                        // Cek apakah masih bisa maju?
                        if (this.activeSlide < this.slides.length - this.itemsPerSlide) {
                            this.activeSlide++;
                        } else {
                            // Jika sudah mentok kanan, KEMBALI KE AWAL (0)
                            this.activeSlide = 0;
                        }
                    },
                    prev() {
                        // LOGIKA LOOPING (INFINITE)
                        // Cek apakah masih bisa mundur?
                        if (this.activeSlide > 0) {
                            this.activeSlide--;
                        } else {
                            // Jika sudah mentok kiri, LOMPAT KE AKHIR
                            this.activeSlide = this.slides.length - this.itemsPerSlide;
                        }
                    }
                }"
                class="relative max-w-6xl mx-auto px-8 md:px-12">

                {{-- WRAPPER SLIDER --}}
                <div class="overflow-hidden py-4">
                    <div class="flex transition-transform duration-500 ease-in-out"
                         :style="'transform: translateX(-' + (activeSlide * (100 / itemsPerSlide)) + '%)'">
                        
                        <template x-for="slide in slides" :key="slide.name">
                            <div :class="'w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3'" 
                                 :style="'width: ' + (100 / itemsPerSlide) + '%'">
                                
                                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 h-full flex flex-col">
                                    
                                    {{-- FOTO (Rasio 3:4 agar sama dengan Kades) --}}
                                    <div class="relative w-full aspect-[3/4] overflow-hidden bg-gray-100 group">
                                        <img :src="'{{ asset('img/aparatur') }}/' + slide.img" 
                                             :alt="slide.name"
                                             class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
                                        
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>

                                    {{-- INFO --}}
                                    <div class="p-5 text-center flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800 leading-tight" x-text="slide.name"></h4>
                                            <p class="text-green-700 font-semibold text-xs uppercase tracking-widest mt-2" x-text="slide.position"></p>
                                        </div>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <p class="text-gray-500 text-sm italic">
                                                "<span x-text="slide.quote"></span>"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                {{-- BUTTON PREV (Sekarang selalu aktif/tidak transparan) --}}
                <button @click="prev()" 
                    class="absolute top-1/2 -left-2 md:-left-6 transform -translate-y-1/2 bg-white text-green-700 p-3 rounded-full shadow-md hover:shadow-lg hover:bg-green-50 transition-all z-10 focus:outline-none hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                {{-- BUTTON NEXT (Sekarang selalu aktif/tidak transparan) --}}
                <button @click="next()" 
                    class="absolute top-1/2 -right-2 md:-right-6 transform -translate-y-1/2 bg-white text-green-700 p-3 rounded-full shadow-md hover:shadow-lg hover:bg-green-50 transition-all z-10 focus:outline-none hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                {{-- DOTS NAVIGASI MOBILE --}}
                <div class="flex justify-center mt-4 md:hidden space-x-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                :class="{'bg-green-600 w-6': activeSlide === index, 'bg-gray-300 w-2': activeSlide !== index}"
                                class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>

            </div>
        </div>
    </div>

@endsection