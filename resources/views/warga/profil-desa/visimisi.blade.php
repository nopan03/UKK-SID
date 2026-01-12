@extends('layouts.app')

@section('title', 'Visi Misi - Desa Suruh')

@section('content')

    <div class="bg-gray-50 pt-40 pb-20 min-h-screen">
        <div class="container mx-auto px-6">
            {{-- Wrapper Konten (md:pl-44) agar geser di desktop --}}
            <div class="md:pl-44">

                {{-- Judul Halaman (Warna Hijau) --}}
                <h1 class="text-4xl font-bold text-green-700 mb-12 text-center md:text-left">
                    Visi & Misi Desa Suruh
                </h1>
                
                {{-- Kotak Konten Putih --}}
                <div class="max-w-4xl mx-auto md:mx-0 bg-white p-8 md:p-12 rounded-lg shadow-lg">
                    
                    {{-- Area Teks (Prose) --}}
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        
                        {{-- ============ KONTEN VISI ANDA ============ --}}
                        <h2 class="text-primary-yellow">VISI DESA SURUH</h2>
                        
                        {{-- Ini adalah kutipan Visi Anda --}}
                        <blockquote class="text-2xl font-semibold italic border-l-4 border-primary-yellow pl-4 my-4">
                            “Bersama Membangun Desa, Menuju Desa yang Maju, Mandiri, dan Berbudaya.”
                        </blockquote>
                        
                        {{-- Ini adalah paragraf penjelasan Visi --}}
                        <p class="mb-4">
                            Keberadaan visi ini merupakan cita-cita yang akan dituju oleh seluruh warga Desa Suruh di masa mendatang. Dengan visi ini diharapkan terwujud masyarakat Desa Suruh yang cerdas sebagai perwujudan SDM unggul sehingga mampu bersaing di era perubahan zaman yang begitu cepat. Selain itu, visi ini juga menjadi dasar dalam mendorong berbagai inovasi pembangunan desa, terutama pada bidang pertanian, perkebunan, peternakan, pertukangan, dan kebudayaan, yang seluruhnya ditopang oleh nilai-nilai keagamaan.
                        </p>


                        {{-- ============ KONTEN MISI ANDA ============ --}}
                        <h2 class="mt-12 text-primary-yellow">MISI DESA SURUH</h2>
                        
                        {{-- Ini adalah paragraf penjelasan Misi --}}
                        <p class="mb-4">
                            Hakekat Misi Desa Suruh merupakan turunan dari Visi Desa Suruh. Misi merupakan tujuan jangka lebih pendek yang mendukung keberhasilan tercapainya visi. Dengan kata lain, Misi Desa Suruh merupakan penjabaran yang lebih operasional dari visi agar pelaksanaannya dapat mengikuti serta mengantisipasi perubahan situasi dan kondisi lingkungan di masa mendatang. Berdasarkan visi yang telah ditetapkan serta mempertimbangkan potensi dan hambatan baik internal maupun eksternal, maka dirumuskan Misi Desa Suruh sebagai berikut:
                        </p>
                        
                        {{-- Ini adalah daftar Misi Anda --}}
                        <ol class="list-decimal pl-5 space-y-3">
                            <li>Meningkatkan kualitas sumber daya manusia melalui pendidikan, pelatihan, dan pemberdayaan masyarakat guna mewujudkan masyarakat yang cerdas dan berdaya saing.</li>
                            <li>Mengembangkan sektor pertanian, perkebunan, dan peternakan melalui inovasi teknologi, peningkatan produktivitas, serta perluasan akses pemasaran.</li>
                            <li>Mendorong pertumbuhan usaha pertukangan dan ekonomi kreatif sebagai upaya meningkatkan pendapatan masyarakat serta memperkuat kemandirian ekonomi desa.</li>
                            <li>Melestarikan dan mengembangkan nilai-nilai kebudayaan lokal sebagai identitas Desa Suruh yang berlandaskan pada nilai-nilai keagamaan.</li>
                            <li>Memperkuat tata kelola pemerintahan desa yang transparan, akuntabel, dan partisipatif agar pelayanan publik semakin efektif dan memberi manfaat bagi masyarakat.</li>
                            <li>Meningkatkan pembangunan infrastruktur desa yang mendukung aktivitas ekonomi, sosial, dan budaya masyarakat.</li>
                            <li>Mendorong kolaborasi antara pemerintah desa, masyarakat, serta pihak eksternal guna mempercepat pembangunan desa secara berkesinambungan.</li>
                        </ol>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection