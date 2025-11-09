<x-app-layout>
    {{-- Ini akan mengisi bagian header di layout utama --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Keuangan Desa') }}
        </h2>
    </x-slot>

    {{-- Ini adalah konten utama halaman Anda --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 text-right">
                        <a href="{{ route('admin.keuangan.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            + Tambah Transaksi
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow">
                            <h3 class="font-bold text-lg">Total Pemasukan</h3>
                            <p class="text-2xl">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow">
                            <h3 class="font-bold text-lg">Total Pengeluaran</h3>
                            <p class="text-2xl">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow">
                            <h3 class="font-bold text-lg">Saldo Akhir</h3>
                            <p class="text-2xl">Rp {{ number_format($saldo_akhir, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 text-left">Tanggal</th>
                                    <th class="py-3 px-4 text-left">Keterangan</th>
                                    <th class="py-3 px-4 text-left">Jenis</th>
                                    <th class="py-3 px-4 text-right">Jumlah</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksis as $transaksi)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td class="py-3 px-4">{{ Str::limit($transaksi->keterangan, 50) }}</td>
                                    <td class="py-3 px-4">
                                        @if ($transaksi->jenis == 'pemasukan')
                                            <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pemasukan</span>
                                        @else
                                            <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right font-medium">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('admin.keuangan.edit', $transaksi->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                        <form action="{{ route('admin.keuangan.destroy', $transaksi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium ml-4">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>