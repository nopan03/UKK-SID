@extends('layouts.app')

@section('title', 'Infografis Penduduk - Desa Suruh')

@section('content')

    <div class="bg-gray-50 pt-40 pb-20 min-h-screen">
        <div class="container mx-auto px-6">
            {{-- Wrapper Konten (md:pl-44) agar geser di desktop --}}
            <div class="md:pl-44">

                <h1 class="text-4xl font-bold text-green-700 mb-12 text-center md:text-left">
                    Infografis Kependudukan
                </h1>
                
                <div class="max-w-7xl mx-auto md:mx-0 bg-white p-8 md:p-12 rounded-lg shadow-lg">
                    
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        <p class="mb-8 text-center md:text-left">
                            Berikut adalah data kependudukan Desa Suruh berdasarkan status terbaru.
                        </p>
                    </div>

                    {{-- Canvas untuk Chart (Tidak berubah) --}}
                    <div class="w-full max-w-md mx-auto mb-8">
                        <canvas id="pieChartPenduduk"></canvas>
                    </div>
                    
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mt-10">
                        <h3 class="text-primary-yellow">Data Ringkas Kependudukan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Jumlah Penduduk Total</td>
                                        {{-- ▼▼ PERUBAHAN: Diberi ID agar bisa diisi JS ▼▼ --}}
                                        <td id="total-penduduk" class="px-6 py-4 whitespace-nowrap text-gray-700">Menghitung...</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Jumlah Laki-laki</td>
                                        {{-- ▼▼ PERUBAHAN: Diberi ID agar bisa diisi JS ▼▼ --}}
                                        <td id="total-laki" class="px-6 py-4 whitespace-nowrap text-gray-700">...</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Jumlah Perempuan</td>
                                        {{-- ▼▼ PERUBAHAN: Diberi ID agar bisa diisi JS ▼▼ --}}
                                        <td id="total-perempuan" class="px-6 py-4 whitespace-nowrap text-gray-700">...</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Jumlah Kepala Keluarga (KK)</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">[... KK]</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Jumlah Dusun</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">3 (Suruh, Prumpon, Lengki)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        //1. Memasukkan Jumlah Penduduk Sesuai Gender    
        const jumlahLaki = 1520;     // <-- GANTI ANGKA INI
        const jumlahPerempuan = 1485; // <-- GANTI ANGKA INI

        // 2. Menghitung total secara otomatis
        const jumlahTotal = jumlahLaki + jumlahPerempuan;

        // 3. Memasukkan data ke dalam tabel HTML
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('total-laki').textContent = jumlahLaki + ' Jiwa';
            document.getElementById('total-perempuan').textContent = jumlahPerempuan + ' Jiwa';
            document.getElementById('total-penduduk').textContent = jumlahTotal + ' Jiwa';
        });

        // 4. Data untuk chart (menggunakan angka dari atas)
        const data = {
            labels: [ 'Laki-laki', 'Perempuan' ],
            datasets: [{
                label: 'Jumlah Penduduk',
                data: [jumlahLaki, jumlahPerempuan], // <-- Otomatis
                backgroundColor: [
                    '#047857',  // Warna Hijau
                    '#FEF100',  // Warna Kuning
                ],
                hoverOffset: 4
            }]
        };

        // 5. Konfigurasi chart (tidak berubah)
        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' Jiwa';
                                }
                                return label;
                            }
                        }
                    }
                }
            },
        };

        // 6. Menggambar chart (tidak berubah)
        const ctx = document.getElementById('pieChartPenduduk');
        new Chart(ctx, config);
    </script>
@endpush