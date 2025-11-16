<section id="sambutan" class="bg-gray-50 py-20">
    <div class="container mx-auto px-6">
        
        {{-- PERUBAHAN: text-3xl -> text-4xl --}}
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">
            Sambutan Kepala Desa
        </h2>
        
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
            
            {{-- Bagian Foto (Tidak diubah) --}}
            <div class="md:col-span-1 relative">
                <div class="absolute inset-0 bg-primary-yellow rounded-lg transform translate-x-3 translate-y-3 z-0 hidden md:block"></div>
                
                <img 
                    src="{{ asset('img/kades.jpeg') }}" 
                    alt="Foto Kepala Desa Suruh" 
                    class="rounded-lg shadow-xl w-full h-full object-contain relative z-10 mt-4 md:mt-0" 
                >
            </div>
            
            {{-- Bagian Teks --}}
            <div class="md:col-span-2 text-center md:text-left">
                {{-- PERUBAHAN: text-2xl -> text-3xl --}}
                <h3 class="text-3xl font-semibold text-green-700 mb-3">
                    Bapak Suwono
                </h3>
                {{-- PERUBAHAN: text-xl -> text-2xl --}}
                <h4 class="text-2xl font-medium text-gray-700 mb-4">
                    Kepala Desa Suruh
                </h4>
                
                {{-- PERUBAHAN: Ditambahkan 'text-lg' untuk memperbesar paragraf --}}
                <p class="text-gray-600 mb-4 leading-relaxed text-lg">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh,
                </p>
                {{-- PERUBAHAN: Ditambahkan 'text-lg' untuk memperbesar paragraf --}}
                <p class="text-gray-600 mb-4 leading-relaxed text-lg">
                    Selamat datang di Website Resmi Desa Suruh. Website ini kami bangun sebagai wujud komitmen kami terhadap transparansi informasi publik dan sebagai sarana untuk mempercepat pelayanan kepada seluruh warga.
                </p>
                {{-- PERUBAHAN: Ditambahkan 'text-lg' untuk memperbesar paragraf --}}
                <p class="text-gray-600 leading-relaxed text-lg">
                    Melalui Sistem Informasi Manajemen Desa (SIMDES) ini, kami berharap dapat menjembatani komunikasi antara pemerintah desa dan masyarakat, serta memudahkan akses terhadap layanan administrasi dan informasi desa. Mari kita bersama-sama membangun Desa Suruh yang lebih maju, cerdas, dan sejahtera.
                </p>
            </div>
            
        </div>
    </div>
</section>