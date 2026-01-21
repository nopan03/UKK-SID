<section class="relative min-h-screen flex items-center overflow-hidden">
    
    {{-- Background Image & Overlay --}}
    <div class="absolute inset-0">
        {{-- Efek Zoom-Out pelan pada background biar lebih hidup --}}
        <img src="{{ asset('img/Sawah.jpg') }}" alt="Background Desa Suruh" 
             class="w-full h-full object-cover transform scale-110 animate-subtle-zoom">
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    {{-- Wrapper Utama --}}
    <div class="relative z-10 container mx-auto px-5">
        <div class="text-center md:-ml-5"> 
        
            {{-- BAGIAN TEKS --}}
            <div class="text-white">
                {{-- Judul 1: Muncul dari bawah --}}
                <h1 class="text-4xl md:text-6xl font-light leading-tight mb-4" 
                    data-aos="fade-up" data-aos-duration="1000">
                    Selamat Datang di Website
                </h1>
                
                {{-- Judul 2 (Desa Suruh): Muncul dari bawah dengan delay --}}
                <p class="text-3xl md:text-5xl font-bold mb-2"
                   data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                    Desa Suruh
                </p>
                
                {{-- Subjudul: Muncul dari bawah dengan delay lebih lama --}}
                <p class="text-xl md:text-2xl font-medium text-gray-200"
                   data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                    Membangun Desa Bersama Melalui Teknologi
                </p>
            </div>

            {{-- BAGIAN IKON --}}
            <div class="mt-16">
                <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                    
                    {{-- Administrasi Surat (Muncul Pertama) --}}
                    <a href="{{ route('surat.index') }}" class="text-center text-white group"
                       data-aos="fade-up" data-aos-delay="600" data-aos-duration="800">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                    transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-file-text text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Administrasi Surat
                        </h3>
                    </a>

                    {{-- Lapor Keluhan (Muncul Kedua - Delay 800ms) --}}
                    <a href="{{ route('keluhan.create') }}" class="text-center text-white group"
                       data-aos="fade-up" data-aos-delay="800" data-aos-duration="800">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                    transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-speakerphone text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Lapor Keluhan
                        </h3>
                    </a>

                    {{-- Infografis Desa (Muncul Ketiga - Delay 1000ms) --}}
                    <a href="{{ route('infografis.penduduk') }}" class="text-center text-white group"
                       data-aos="fade-up" data-aos-delay="1000" data-aos-duration="800">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                    transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-chart-pie text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Infografis Desa
                        </h3>
                    </a>

                </div>
            </div>

        </div> 
    </div>
</section>

{{-- Tambahan CSS Custom untuk Efek Zoom Background (Letakkan di head atau style block layout utama) --}}
<style>
    @keyframes subtleZoom {
        0% { transform: scale(1.0); }
        100% { transform: scale(1.1); }
    }
    .animate-subtle-zoom {
        animation: subtleZoom 20s infinite alternate ease-in-out;
    }
</style>