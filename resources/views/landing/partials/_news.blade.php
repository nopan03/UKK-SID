<section id="news" class="bg-white py-20 overflow-hidden">
    <div class="container mx-auto px-6">
        
        {{-- JUDUL --}}
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12"
            data-aos="fade-down" data-aos-duration="1000">
            Berita & Informasi Terkini
        </h2>

        {{-- Cek apakah ada berita untuk ditampilkan --}}
        @if ($beritas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach ($beritas as $berita)
    
                    {{-- 
                       🔥 PERBAIKAN DI SINI 🔥
                       Link diarahkan ke route 'berita.detail'. 
                       Karena route ini kena middleware 'auth', jika belum login otomatis dilempar ke Login.
                    --}}
                    <a href="{{ route('berita.detail', $berita->id) }}" 
                       data-aos="fade-up" 
                       data-aos-delay="{{ $loop->iteration * 200 }}" 
                       data-aos-duration="1000"
                       class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-2xl">
                        
                        {{-- 2. BAGIAN GAMBAR --}}
                        <div class="relative overflow-hidden">
                            <img class="h-56 w-full object-cover transition-all duration-500 group-hover:scale-110 group-hover:rotate-1"
                                 src="{{ asset('storage/' . $berita->gambar) }}" 
                                 alt="{{ $berita->judul }}">
                            
                            {{-- Overlay Keterangan --}}
                            <div class="absolute bottom-0 left-0 right-0
                                        bg-gradient-to-t from-green-900/95 to-transparent
                                        translate-y-full group-hover:translate-y-0
                                        transition-transform duration-500 ease-out">
                                <div class="max-h-40 overflow-y-auto p-4"> 
                                    <p class="text-sm text-green-50 leading-relaxed">
                                        {{ strip_tags($berita->isi) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 3. KONTEN TEKS --}}
                        <div class="p-6 flex-1 flex flex-col relative bg-white">
                            
                            {{-- Tanggal --}}
                            <div class="flex items-center text-xs text-gray-400 mb-2">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                            </div>
                            
                            {{-- Judul --}}
                            <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight transition-colors duration-300 group-hover:text-green-600">
                                {{ $berita->judul }}
                            </h3>
                            
                            <div class="flex-1"></div>

                            {{-- Indikator Visual (Gembok / Panah) --}}
                            <div class="mt-4 flex items-center text-sm font-semibold transition-all duration-300 group-hover:translate-x-0 transform translate-x-[-10px] opacity-0 group-hover:opacity-100">
                                
                                @auth
                                    {{-- Jika Sudah Login: Tampilkan Panah Hijau --}}
                                    <span class="text-green-600 flex items-center">
                                        Baca Selengkapnya 
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </span>
                                @else
                                    {{-- Jika Belum Login: Tampilkan Gembok (Kode visual bahwa ini dikunci) --}}
                                    <span class="text-gray-500 flex items-center">
                                        Login untuk Baca
                                        <i class="ti ti-lock w-4 h-4 ml-1"></i>
                                    </span>
                                @endauth

                            </div>
                            
                        </div>
                    </a>
                @endforeach

            </div>
        @else
            {{-- Pesan Kosong --}}
            <div class="text-center py-10" data-aos="zoom-in">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="ti ti-news-off text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">Belum ada berita untuk ditampilkan saat ini.</p>
            </div>
        @endif

    </div>
</section>