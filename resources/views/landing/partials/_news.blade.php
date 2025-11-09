<section id="news" class="bg-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Berita & Informasi Terkini</h2>

        {{-- Cek apakah ada berita untuk ditampilkan --}}
        @if ($beritas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Lakukan perulangan untuk setiap berita --}}
               {{-- Ganti blok @foreach ... @endforeach Anda dengan ini --}}

@foreach ($beritas as $berita)
    
    {{-- 1. Wrapper Kartu (Link) --}}
    <a href="#" {{-- Ganti # dengan link detail berita nanti --}}
       class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col
              group transition-all duration-300
              hover:shadow-2xl">
        
        {{-- 2. BAGIAN GAMBAR (Dibuat 'relative' untuk menampung overlay) --}}
        <div class="relative overflow-hidden">
            
            {{-- Gambar Utama --}}
            <img class="h-56 w-full object-cover
                        transition-all duration-300 group-hover:scale-105"
                 src="{{ asset('storage/' . $berita->gambar) }}" 
                 alt="{{ $berita->judul }}">
            
            {{-- 3. OVERLAY KETERANGAN (Ini yang akan slide-up) --}}
            {{-- Awalnya tersembunyi (translate-y-full) --}}
            <div class="absolute bottom-0 left-0 right-0
                        bg-gradient-to-t from-green-900/90 to-transparent
                        translate-y-full group-hover:translate-y-0
                        transition-transform duration-500 ease-in-out">
                
                {{-- Pembungkus konten agar bisa di-scroll jika terlalu panjang --}}
                <div class="max-h-40 overflow-y-auto p-4"> 
                    <p class="text-sm text-green-100">
                        {{-- Teks lengkap (Str::limit dihapus) --}}
                        {{ strip_tags($berita->isi) }}
                    </p>
                </div>

            </div>
        </div>

        {{-- 4. KONTEN TEKS DI BAWAH GAMBAR (Card Putih) --}}
        <div class="p-6 flex-1 flex flex-col">
            
            {{-- Tanggal (Selalu Terlihat di card putih) --}}
            <p class="text-sm text-gray-500 mb-2">
                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
            </p>
            
            {{-- Judul (Selalu Terlihat di card putih) --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-2 
                       transition-colors duration-300 group-hover:text-green-600">
                {{ $berita->judul }}
            </h3>
            
            <div class="flex-1"></div>
            
        </div>
    </a>
@endforeach {{-- Akhir dari perulangan --}}

            </div>
        @else
            <p class="text-center text-gray-600">Belum ada berita untuk ditampilkan.</p>
        @endif

    </div>
</section>
