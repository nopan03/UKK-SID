<section class="relative min-h-screen flex items-center overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0">
        <img src="{{ asset('img/Sawah.jpg') }}" alt="Background Desa Suruh" 
             class="w-full h-full object-cover transform scale-110 animate-subtle-zoom">
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    {{-- Wrapper --}}
    <div class="relative z-10 container mx-auto px-5">
        <div class="text-center md:-ml-5"> 
            
            {{-- Teks Judul --}}
            <div class="text-white">
                <h1 class="text-4xl md:text-6xl font-light leading-tight mb-4" data-aos="fade-up" data-aos-duration="1000">Selamat Datang di Website</h1>
                <p class="text-3xl md:text-5xl font-bold mb-2" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">Desa Suruh</p>
                <p class="text-xl md:text-2xl font-medium text-gray-200" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">Membangun Desa Bersama Melalui Teknologi</p>
            </div>

            {{-- BAGIAN IKON --}}
            <div class="mt-16">
                
                {{-- 🔥 LOGIKA TAMPILAN IKON TERPUSAT DI SINI 🔥 --}}
                @php
                    // Cek apakah dia Pendatang (User Login & Role Pengunjung)
                    $isPendatang = Auth::check() && Auth::user()->role == 'pengunjung';
                @endphp

                @if($isPendatang)
                    {{-- 
                        🟢 TAMPILAN A: KHUSUS PENDATANG 
                        Hanya 1 Tombol Besar di Tengah
                    --}}
                    <div class="max-w-xs mx-auto"> 
                        <a href="{{ route('lapor.index') }}" class="block text-center text-white group"
                           data-aos="fade-up" data-aos-delay="600" data-aos-duration="800">
                            <div class="flex items-center justify-center h-24 w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-alert-circle text-yellow-400 text-7xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-yellow-300 transition-colors duration-300 group-hover:text-yellow-400">
                                Lapor Diri (Wajib)
                            </h3>
                            <p class="text-sm text-gray-300 mt-2">Anda harus melapor diri terlebih dahulu untuk mengakses layanan.</p>
                        </a>
                    </div>

                @else
                    {{-- 
                        🔵 TAMPILAN B: USER BIASA / TAMU 
                        Tampilkan 3 Tombol Standar (Surat, Keluhan, Info)
                    --}}
                    <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                        
                        {{-- Tombol 1: Surat --}}
                        <a href="{{ route('surat.index') }}" class="text-center text-white group" data-aos="fade-up" data-aos-delay="600" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti {{ Auth::check() ? 'ti-file-text' : 'ti-login' }} text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">
                                {{ Auth::check() ? 'Administrasi Surat' : 'Masuk / Surat' }}
                            </h3>
                        </a>

                        {{-- Tombol 2: Keluhan --}}
                        <a href="{{ route('keluhan.create') }}" class="text-center text-white group" data-aos="fade-up" data-aos-delay="800" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-speakerphone text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">Lapor Keluhan</h3>
                        </a>

                        {{-- Tombol 3: Infografis --}}
                        <a href="{{ route('infografis.penduduk') }}" class="text-center text-white group" data-aos="fade-up" data-aos-delay="1000" data-aos-duration="800">
                            <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3 transform transition-transform duration-300 group-hover:scale-110">
                                <i class="ti ti-chart-pie text-yellow-400 text-5xl md:text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">Infografis Desa</h3>
                        </a>
                    </div>
                @endif

            </div>
        </div> 
    </div>
</section>

<style>
    @keyframes subtleZoom { 0% { transform: scale(1.0); } 100% { transform: scale(1.1); } }
    .animate-subtle-zoom { animation: subtleZoom 20s infinite alternate ease-in-out; }
</style>