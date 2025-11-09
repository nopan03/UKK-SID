<footer class="bg-yellow-400 text-green-900">
    {{-- 
      PERUBAHAN DI SINI:
      'py-12' (padding atas-bawah 48px) diubah menjadi 'py-8' (32px) 
    --}}
    <div class="container mx-auto py-8 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-green-800 mb-4">Pemerintah Desa Suruh</h3>
                <p class="text-green-700">Jl. Raya Pembangunan No. 1<br>Kecamatan Kode, Kabupaten Laravel<br>Kode Pos: 54321</p>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-green-800 mb-4">Kontak</h3>
                <p class="text-green-700">Email: kontak@suruh.desa.id<br>Telepon: (021) 123-456</p>
            </div>

        </div>
        
        {{-- 
          PERUBAHAN DI SINI:
          'mt-8 pt-6' (margin & padding) diubah menjadi 'mt-6 pt-4' 
        --}}
        <div class="border-t border-green-700 opacity-60 mt-6 pt-4 text-center text-green-800">
            <p>&copy; {{ date('Y') }} Desa Suruh. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>