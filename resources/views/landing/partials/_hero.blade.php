{{-- 
  PERBAIKAN POSISI:
  'flex flex-col' di section utama akan membagi layout secara vertikal.
--}}
<section class="relative min-h-screen flex flex-col">
    
    <div class="absolute inset-0">
        <img src="{{ asset('img/Sawah.jpg') }}" alt="Background Desa Suruh" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    {{-- 
      Wrapper Konten: 'flex-grow' membuatnya mengisi seluruh ruang, 
      'flex-col' membaginya lagi.
    --}}
    <div class="relative z-10 flex flex-col flex-grow">
        
        {{-- 
          PERBAIKAN POSISI 1:
          'flex-1' (sama dengan flex-grow) membuat div ini mengambil semua 
          ruang yang tersedia.
          'flex flex-col justify-center' membuat teks di DALAMNYA 
          berada TEPAT DI TENGAH.
        --}}
        <div class="flex-1 flex flex-col justify-center">
            <div class="text-center text-white px-4">
                
                {{-- PERBAIKAN FONT (Sesuai permintaan Anda) --}}
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
        </div>

        {{-- 
          PERBAIKAN POSISI 2:
          Div ini tidak memiliki 'flex-grow', sehingga akan otomatis 
          terdorong ke paling bawah.
          'pb-16' atau 'pb-20' memberi jarak dari tepi bawah layar.
        --}}
        <div class="container mx-auto px-6 pb-16 md:pb-20">
            <div class="grid grid-cols-3 gap-4 max-w-xl mx-auto">
                
                {{-- LAYANAN 1: ADMINISTRASI SURAT --}}
                <a href="#" class="text-center text-white group">
                    <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                transform transition-transform duration-300 group-hover:scale-110">
                        <i class="ti ti-file-text text-yellow-400 text-5xl md:text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">
                        Administrasi Surat
                    </h3>
                </a>

                {{-- LAYANAN 2: LAPOR KELUHAN --}}
                <a href="#" class="text-center text-white group">
                    <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                transform transition-transform duration-300 group-hover:scale-110">
                        <i class="ti ti-speakerphone text-yellow-400 text-5xl md:text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">
                        Lapor Keluhan
                    </h3>
                </a>

                {{-- LAYANAN 3: INFOGRAFIS DESA --}}
                <a href="#" class="text-center text-white group">
                    <div class="flex items-center justify-center h-20 w-20 md:h-24 md:w-24 mx-auto mb-3
                                transform transition-transform duration-300 group-hover:scale-110">
                        <i class="ti ti-chart-pie text-yellow-400 text-5xl md:text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold transition-colors duration-300 group-hover:text-yellow-400">
                        Infografis Desa
                    </h3>
                </a>

            </div>
        </div>
    </div>
</section>