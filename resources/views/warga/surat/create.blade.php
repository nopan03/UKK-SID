@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('content')
<div class="bg-gray-50 pt-10 pb-20 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- Tombol Kembali --}}
            <div class="mb-6">
                <a href="{{ route('surat.index') }}" class="text-gray-500 hover:text-green-600 flex items-center gap-1 text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Daftar Layanan
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-600">
                <div class="p-6 border-b border-gray-100 bg-green-50">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Formulir Pengajuan <span class="text-green-700 uppercase">{{ $jenis }}</span>
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Silakan lengkapi data dan upload berkas yang diperlukan.</p>
                </div>

                <div class="p-8">
                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <p class="text-sm text-red-700 font-bold">Terdapat kesalahan:</p>
                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Start --}}
                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat" value="{{ $jenis }}">

                        {{-- Bagian 1: Data Diri --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                                <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-2 text-xs font-bold">1</span> Data Pemohon
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                    <input type="text" value="{{ Auth::user()->nik }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        {{-- Bagian 2: Detail Surat (Partials) --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                                <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-2 text-xs font-bold">2</span> Detail & Dokumen
                            </h3>
                            
                            {{-- Include Partial Sesuai Jenis --}}
                            @if(view()->exists('warga.surat.partials.form-'.$jenis))
                                @include('warga.surat.partials.form-'.$jenis)
                            @else
                                @include('warga.surat.partials.form-default')
                            @endif
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection