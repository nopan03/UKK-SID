<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- PERBAIKAN UTAMA ADA DI SINI --}}
                    @if($berita->gambar)
                        {{-- Path ini sekarang mencari langsung ke folder public/images/berita/ --}}
                        <img src="{{ asset('images/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-auto max-h-96 object-cover rounded-lg mb-6">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg mb-6 flex items-center justify-center">
                            <p class="text-gray-500">Tidak ada gambar</p>
                        </div>
                    @endif
                    
                    <h1 class="text-3xl font-bold mb-2">{{ $berita->judul }}</h1>
                    
                    <div class="text-sm text-gray-500 mb-4 border-b pb-4">
                        <span>Kategori: {{ $berita->kategori }}</span> |
                        <span>Dipublikasikan pada: {{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}</span> |
                        <span>Penulis: {{ $berita->user->name ?? 'N/A' }}</span>
                    </div>

                    <div class="prose max-w-none mt-6">
                        {!! nl2br(e($berita->isi)) !!}
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t pt-6">
                        <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>