{{-- Tambahkan Style Khusus untuk Animasi Warna Background --}}
<style>
    @keyframes colorPulse {
        0% { background-color: #f9fafb; } /* gray-50 */
        50% { background-color: #f0fdf4; } /* green-50 (Hijau Tipis) */
        100% { background-color: #f9fafb; } /* gray-50 */
    }
    .animate-bg-pulse {
        animation: colorPulse 6s infinite ease-in-out; /* Berulang setiap 6 detik */
    }
</style>

{{-- SECTION SAMBUTAN --}}
{{-- Tambahkan class 'animate-bg-pulse' agar warnanya berubah-ubah --}}
<section id="sambutan" class="py-20 animate-bg-pulse overflow-hidden">
    <div class="container mx-auto px-6">
        
        {{-- Judul: Muncul dari Atas --}}
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12"
            data-aos="fade-down" data-aos-duration="1000">
            Sambutan Kepala Desa
        </h2>
        
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
            
            {{-- Bagian Foto: Muncul dari KIRI --}}
            <div class="md:col-span-1 relative" 
                 data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                
                {{-- Kotak Kuning di belakang foto --}}
                <div class="absolute inset-0 bg-primary-yellow rounded-lg transform translate-x-3 translate-y-3 z-0 hidden md:block"></div>
                
                <img 
                    src="{{ asset('img/kades.jpeg') }}" 
                    alt="Foto Kepala Desa Suruh" 
                    class="rounded-lg shadow-xl w-full h-full object-contain relative z-10 mt-4 md:mt-0 transition duration-500 hover:scale-105" 
                >
            </div>
            
            {{-- Bagian Teks: Muncul dari KANAN --}}
            <div class="md:col-span-2 text-center md:text-left"
                 data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                
                <h3 class="text-3xl font-semibold text-green-700 mb-3">
                    Bapak Suwono
                </h3>
                
                <h4 class="text-2xl font-medium text-gray-700 mb-4">
                    Kepala Desa Suruh
                </h4>
                
                <div class="space-y-4 text-gray-600 leading-relaxed text-lg">
                    <p>
                        Assalamu'alaikum Warahmatullahi Wabarakatuh,
                    </p>
                    <p>
                        Selamat datang di Website Resmi Desa Suruh. Website ini kami bangun sebagai wujud komitmen kami terhadap transparansi informasi publik dan sebagai sarana untuk mempercepat pelayanan kepada seluruh warga.
                    </p>
                    <p>
                        Melalui Sistem Informasi Manajemen Desa (SIMDES) ini, kami berharap dapat menjembatani komunikasi antara pemerintah desa dan masyarakat, serta memudahkan akses terhadap layanan administrasi dan informasi desa. Mari kita bersama-sama membangun Desa Suruh yang lebih maju, cerdas, dan sejahtera.
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</section>