@extends('layouts.app')

@section('title', 'Sejarah Desa - Desa Suruh')

@section('content')

    <div class="bg-gray-50 pt-40 pb-20 min-h-screen">
        <div class="container mx-auto px-6">
            <div class="md:pl-44">

                {{-- ▼▼ PERUBAHAN WARNA ADA DI BARIS INI ▼▼ --}}
                <h1 class="text-4xl font-bold text-green-700 mb-12 text-center md:text-left">
                    Sejarah Desa Suruh
                </h1>
                
                <div class="max-w-4xl mx-auto md:mx-0 bg-white p-8 md:p-12 rounded-lg shadow-lg">
                    
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        
                        <p class="mb-4">
                            Sebelum ada nama Desa Suruh seperti yang kita kenal di Kecamatan Sukodono, Sidoarjo, wilayah ini tidaklah utuh sebagai satu kesatuan. Sejarahnya dimulai dari tiga cerita 'babad alas' (pembukaan lahan) yang terpisah di tiga lokasi berbeda, yang kemudian melahirkan Dusun Suruh, Dusun Prumpon, dan Dusun Lengki. Fakta menariknya di sini adalah perbedaan penting antara 'Desa' dan 'Dusun'; Desa Suruh adalah nama 'payung' administratif modern yang menaungi ketiganya, sementara Dusun Suruh (yang namanya kebetulan sama) adalah salah satu dari dusun-dusun tersebut yang memiliki ceritanya sendiri. Jadi, Desa Surah saat ini terbentuk dari gabungan wilayah-wilayah yang dulunya memiliki legenda dan riwayat pendirinya masing-masing.
                        </p>

                        {{-- === Bagian Sejarah Dusun Suruh === --}}
                        <h2 class="mt-8 mb-4 text-primary-yellow">Sejarah Dusun Suruh</h2>
                        
                        {{-- Ganti dengan foto Dusun Suruh Anda --}}
                        <img src="{{ asset('img/placeholder_suruh.jpg') }}" alt="Ilustrasi Dusun Suruh" class="rounded-lg mb-6 w-full object-cover h-64 md:h-80 shadow-md">
                        
                        <p class="mb-4">
                            Dusun Suruh orang yang pertama kali membuka lahan untuk Dusun yang bernama ( Mbah Darmolaku ). Diceritakan bahwa pada zaman dahulu ada seorang pertapa yang sakti yang suka dengan tanaman-tanaman dan suatu waktu Mbah Darmolaku menemukan Tanaman yang jumlahnya sangat banyak dan berbau Harum, di sebelah selatan menemukan dedaunan yang harum, dan sebelah utara daun tersebut sama tetapi tidak seharum yang selatan, teryata daun itu Adalah daun Suruh yang sangat berkhasiat untuk kesehatan, sejak itu Dusun tersebut dinamakan Dusun Suruh, Narasumber dari Bu Juminten Penjaga Kramat Dusun Suruh.
                        </p>

                        {{-- === Bagian Sejarah Dusun Prumpon === --}}
                        <h2 class="mt-8 mb-4 text-primary-yellow">Sejarah Dusun Prumpon</h2>
                        
                        {{-- Ganti dengan foto Dusun Prumpon Anda --}}
                        <img src="{{ asset('img/placeholder_prumpon.jpg') }}" alt="Ilustrasi Dusun Prumpon" class="rounded-lg mb-6 w-full object-cover h-64 md:h-80 shadow-md">
                        
                        <p class="mb-4">
                            Dusun Prumpon yang babat Dusun pertama kali adalah Bernama Mbah Putri Roro Kuning. Di ceritakan pada zaman dulu adalah seorang pertapa sakti dan prajurit mataram yang perang melawan pajajaran kalah sehingga menepi dan memutuskan bertapa di Goa di daerah Bulengleng Bali, di sana beliau bertemu dengan Syeh Maulana Iskak ( Adik dari Raja Bulengleng ) seorang pengembara yang ahli pengobatan sampai di suatu waktu mereka bertemu di Bulengleng saat mbah putri roro kuning bertapa dan beliau merasa terusik dengan keberadaan Syeh Maulana Iskak sehingga Mbah Putri Roro Kuning bergeser ke Jawa, saat Mbah Putri Roro Kuning sakit dan ber-sayembara jika yang dapat menolong akan bersedia di jadikan istri, bertemukah kembali dengan Syah Maulana Iskak untuk memberikan pertolongan dengan syarat harus masuk Muslim terlebih dulu. Setelah itu mbah Putri Roro Kuning menetap di daerah yang di aliri sungai dan banyak ikannya yang di sebut juga Rumpon, sederhana hingga lambat laun masyarakat menyederhanakan kalimat tersebut menjadi "PRUMPON" yang sebelumnya bermula dari kalimat "RUMPON" yang artinya Rumah/Tempat tinggal ikan-ikan. Narasumber bu katijah penjaga kramat Dusun Prumpon.
                        </p>

                        {{-- === Bagian Sejarah Dusun Lengki === --}}
                        <h2 class="mt-8 mb-4 text-primary-yellow">Sejarah Dusun Lengki</h2>
                        
                        {{-- Ganti dengan foto Dusun Lengki Anda --}}
                        <img src="{{ asset('img/placeholder_lengki.jpg') }}" alt="Ilustrasi Dusun Lengki" class="rounded-lg mb-6 w-full object-cover h-64 md:h-80 shadow-md">
                        
                        <p class="mb-4">
                            Dusun Lengki merupakan salah satu dari tiga Dusun yang ada di Desa suruh akan tetapi letaknya yang jauh diujung desa memiliki sebuah cerita tersendiri. Sesuai yang berkembang di masyarakat Dusun Lengki dan dituturkan oleh para sesepuh dusun menyebutkan, bahwa pada masa lampau sekitar masa pemerintahan Hindia-Belanda daerah Lengki masih berupa hutan belantara serta rawa-rawa yang masih belum ada penghuninya. Saat itu seseorang yang berkelana bernama Baropati atau Wiropati melewati daerah tersebut dan hanya menjumpai hutan yang di dalamnya dijumpai sebuah teleng dalam bahasa indonesia ialah kolam atau rawa yang tidak terurus. Hingga akhirnya Mbah Baropati memutuskan untuk menetap dan membuka daerah tersebut menjadi sebuah permukiman. Sesuai keadaan wilayah yang berwujud kolam rawa/teleng, daerah tersebut diberi nama"Teleng" sehingga dalam bahasa jawa diucapkan kalimat "iki teleng" (ini merupakan daerah teleng). Akan tetapi dalam pengucapannya yang terlalu panjang untuk menyederhanakan ucapan biasanya masyarakat Jawa memilih untuk menyingkat kalimat agar sederhana hingga lambat laun masyarakat menyederhanakan kalimat tersebut menjadi "Lengki" yang sebelumnya bermula dari kalimat "iki Teleng". 60 sampai saat ini masyarakat Dusun lengki tidak mengetahui silsilah dari keluarga Mbah Baropati secara lengkap, tetapi ada yang beranggapan beliau termasuk pengelana dari kerajaan Majapahit yang mengasingkan diri. Masyarakat juga tetap percaya dan menghormati segala jasa Mbah Baropati yang telah 'mbabat alas'(membuka suatu daerah) menjadi sebuah pemukiman yaitu Dusun Lengki. Untuk menghormati jasa-jasa beliau sebagian masyarakat melakukan syukuran yang berada di makam beliau yakni pada saat sebelum bulan Ramadhan dan ketika sebagian masyarakat ada yang memiliki hajatan seperti pernikahan, sunatan dan hajatan yang lainya. Tidak jarang masyarakat juga nyekar dan berdoa dimakam beliau sebagai wujud syukur dan menghormati leluhur untuk menghargai segala jasa yang telah beliau berikan sebelumnya.
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection