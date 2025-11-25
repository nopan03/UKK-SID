<section class="relative min-h-screen flex items-center">
    
    {{-- Background Image & Overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('img/Sawah.jpg') }}" alt="Background Desa Suruh" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    {{-- Wrapper Utama --}}
    <div class="relative z-10 container mx-auto px-6">
        
        {{-- 
           PERUBAHAN POSISI:
           - md:pl-20: Sebelumnya 40. Saya kurangi jadi 20 agar konten 
             geser KEMBALI KE KIRI (mendekat ke logo).
        --}}
        <div class="text-center md:pl-20">
        
            {{-- BAGIAN TEKS --}}
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

            {{-- BAGIAN IKON --}}
            <div class="mt-16">
                <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                    
                    <a href="#" class="text-center text-white group">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                     transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-file-text text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Administrasi Surat
                        </h3>
                    </a>

                    <a href="#" class="text-center text-white group">
                        <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                     transform transition-transform duration-300 group-hover:scale-110">
                            <i class="ti ti-speakerphone text-primary-yellow text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-primary-yellow">
                            Lapor Keluhan
                        </h3>
                    </a>

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
    </div>
</section>