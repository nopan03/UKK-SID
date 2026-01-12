@extends('layouts.app')

@section('title', 'Infografis Kependudukan')

@section('content')
    
    {{-- HERO SECTION --}}
    <div class="bg-green-700 py-16 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Statistik Kependudukan</h1>
            <p class="text-green-100 text-lg">
                Data demografi warga Desa Suruh yang transparan dan akurat.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[30px] md:h-[40px]" data-name="Layer 1"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                 preserveAspectRatio="none">
                <path d="M0,0V120H1200V0S600,40,0,0Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <div class="bg-gray-50 py-12 min-h-screen">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- 1. KARTU RINGKASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- Total --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600 flex items-center hover:shadow-md transition">
                    <div class="p-4 bg-green-50 rounded-full text-green-700 mr-4">
                        <i class="ti ti-users text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Penduduk</p>
                        <h3 class="text-3xl font-bold text-gray-800">
                            {{ number_format($totalPenduduk) }}
                            <span class="text-sm font-normal text-gray-400">Jiwa</span>
                        </h3>
                    </div>
                </div>

                {{-- Laki-laki --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-emerald-500 flex items-center hover:shadow-md transition">
                    <div class="p-4 bg-emerald-50 rounded-full text-emerald-600 mr-4">
                        <i class="ti ti-man text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Laki-laki</p>
                        <h3 class="text-3xl font-bold text-gray-800">
                            {{ number_format($totalLaki) }}
                            <span class="text-sm font-normal text-gray-400">Jiwa</span>
                        </h3>
                    </div>
                </div>

                {{-- Perempuan --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-400 flex items-center hover:shadow-md transition">
                    <div class="p-4 bg-yellow-50 rounded-full text-yellow-500 mr-4">
                        <i class="ti ti-woman text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Perempuan</p>
                        <h3 class="text-3xl font-bold text-gray-800">
                            {{ number_format($totalPerempuan) }}
                            <span class="text-sm font-normal text-gray-400">Jiwa</span>
                        </h3>
                    </div>
                </div>
            </div>

            {{-- 2. GRAFIK VISUAL (PEKERJAAN SAJA) --}}
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
                
                {{-- Chart Pekerjaan --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-3 flex items-center">
                        <i class="ti ti-briefcase mr-2 text-green-600"></i>
                        Distribusi Pekerjaan Utama
                    </h3>
                    <div class="relative h-72 w-full" id="containerPekerjaan">
                        <canvas id="chartPekerjaan"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari Controller
            const labelPekerjaan = @json($labelPekerjaan);
            const dataPekerjaan  = @json($dataPekerjaan);

            // Chart Pekerjaan (Bar Horizontal)
            if (labelPekerjaan && labelPekerjaan.length > 0) {
                new Chart(document.getElementById('chartPekerjaan'), {
                    type: 'bar',
                    data: {
                        labels: labelPekerjaan,
                        datasets: [{
                            label: 'Jumlah Orang',
                            data: dataPekerjaan,
                            backgroundColor: '#16A34A', // hijau tema desa
                            borderRadius: 6,
                            barThickness: 30
                        }]
                    },
                    options: {
                        indexAxis: 'y', // bar horizontal
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { beginAtZero: true }
                        }
                    }
                });
            } else {
                // Pesan jika data kosong
                document.getElementById('containerPekerjaan').innerHTML =
                    '<div class="flex h-full items-center justify-center text-gray-400 italic">Belum ada data pekerjaan.</div>';
            }
        });
    </script>

@endsection
