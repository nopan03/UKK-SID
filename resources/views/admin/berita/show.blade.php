<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <img class="w-full h-96 object-cover object-center" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">

                <div class="p-6 sm:p-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                        {{ $berita->judul }}
                    </h1>

                    <div class="flex items-center text-sm text-gray-500 space-x-6 mb-6 border-b pb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $berita->user->name ?? 'Admin' }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $berita->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-800">
                        {!! $berita->isi !!}
                    </div>

                    <div class="mt-10 text-right">
                        <a href="{{ url()->previous() }}" class="inline-block bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                            &larr; Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>