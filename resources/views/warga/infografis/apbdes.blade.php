@extends('layouts.app')

@section('title', 'Infografis APBDes')

@section('content')

    {{-- 1. HERO SECTION --}}
    <div class="bg-green-700 py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Transparansi Anggaran Desa</h1>
            <p class="text-green-100 text-lg">Laporan Realisasi APBDes Tahun {{ date('Y') }}</p>
        </div>
        {{-- Hiasan Bawah --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
             <svg class="relative block w-full h-[30px] md:h-[40px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V120H1200V0S600,40,0,0Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 py-12 min-h-screen">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- 2. KARTU RINGKASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Pemasukan -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500 flex flex-col items-center text-center">
                    <div class="p-3 bg-green-100 text-green-600 rounded-full mb-3">
                        <i class="ti ti-arrow-up-right text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-bold uppercase">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-red-500 flex flex-col items-center text-center">
                    <div class="p-3 bg-red-100 text-red-600 rounded-full mb-3">
                        <i class="ti ti-arrow-down-right text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-bold uppercase">Total Belanja</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>

                <!-- Sisa (Silpa) -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 flex flex-col items-center text-center">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-full mb-3">
                        <i class="ti ti-wallet text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-bold uppercase">Sisa Anggaran</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- 3. GRAFIK VISUAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                
                <!-- Grafik Pemasukan (Donut) -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="ti ti-chart-pie mr-2 text-green-500"></i> Sumber Pendapatan
                    </h3>
                    <div class="relative h-72">
                        <canvas id="chartPemasukan"></canvas>
                    </div>
                </div>

                <!-- Grafik Pengeluaran (Bar) -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2 flex items-center">
                        <i class="ti ti-chart-bar mr-2 text-red-500"></i> Realisasi Belanja
                    </h3>
                    <div class="relative h-72">
                        <canvas id="chartPengeluaran"></canvas>
                    </div>
                </div>
            </div>

            {{-- 4. TABEL RINCIAN TRANSAKSI --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="ti ti-list-details mr-2 text-gray-400"></i> Rincian Transaksi Terakhir
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Uraian</th>
                                <th class="px-6 py-3 text-center">Jenis</th>
                                <th class="px-6 py-3 text-right">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $item)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-700">
                                        {{ $item->kategori }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ Str::limit($item->keterangan, 50) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->jenis == 'pemasukan')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Masuk</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold {{ $item->jenis == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        Belum ada data transaksi tahun ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Controller (dikirim via JSON)
        const labelMasuk = @json($labelMasuk);
        const dataMasuk = @json($dataMasuk);
        const labelKeluar = @json($labelKeluar);
        const dataKeluar = @json($dataKeluar);

        // 1. Chart Pemasukan (Doughnut)
        if(labelMasuk.length > 0) {
            new Chart(document.getElementById('chartPemasukan'), {
                type: 'doughnut',
                data: {
                    labels: labelMasuk,
                    datasets: [{
                        data: dataMasuk,
                        backgroundColor: [
                            '#10B981', '#34D399', '#6EE7B7', '#059669', '#065F46' // Variasi Hijau
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        } else {
            // Jika data kosong, tampilkan teks placeholder (opsional)
            document.getElementById('chartPemasukan').parentElement.innerHTML = '<p class="text-center text-gray-400 mt-10">Belum ada data pemasukan.</p>';
        }

        // 2. Chart Pengeluaran (Bar)
        if(labelKeluar.length > 0) {
            new Chart(document.getElementById('chartPengeluaran'), {
                type: 'bar',
                data: {
                    labels: labelKeluar,
                    datasets: [{
                        label: 'Jumlah Belanja (Rp)',
                        data: dataKeluar,
                        backgroundColor: '#EF4444', // Merah
                        borderRadius: 6
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        } else {
            document.getElementById('chartPengeluaran').parentElement.innerHTML = '<p class="text-center text-gray-400 mt-10">Belum ada data pengeluaran.</p>';
        }
    </script>

@endsection