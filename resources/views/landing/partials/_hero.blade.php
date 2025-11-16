<section class="relative min-h-screen">
    
    {{-- Background Image & Overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('img/Sawah.jpg') }}" alt="Background Desa Suruh" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    {{-- Wrapper Konten Utama (dengan pt-40) --}}
    <div class="relative z-10 container mx-auto px-6 
                flex flex-col min-h-screen justify-between 
                pt-40 pb-20"> 
        
        <div class="text-center md:pl-35">
        
            {{-- BAGIAN TEKS "SELAMAT DATANG" --}}
            <div class="text-white">
                <h1 class="text-4xl md:text-6xl font-light leading-tight mb-4">
                    Selamat Datang di Website
                </h1>
                <p class="text-3xl md:text-5xl font-bold mb-2">
                    Desa Suruh
                </p>
                <p class="text-xl md:text-2xl font-medium text-gray-200">
                    Membangun Desa Bersama Melalui Teknologi
                </p>
            </div>

            {{-- BAGIAN IKON LAYANAN --}}
            <div class="mt-16">
                <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                    
                    {{-- LAYANAN 1: ADMINISTRASI SURAT --}}
                    <a href="#" class="text-center text-white group">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                     transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-file-text text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Administrasi Surat
                        </h3>
                    </a>

                    {{-- LAYANAN 2: LAPOR KELUHAN --}}
                    <a href="#" class="text-center text-white group">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                     transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-speakerphone text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Lapor Keluhan
                        </h3>
                    </a>

                    {{-- LAYANAN 3: INFOGRAFIS DESA --}}
                    <a href="#" class="text-center text-white group">
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
        {{-- ▲▲ Akhir dari Wrapper Responsif --}}

    </div>
</section>