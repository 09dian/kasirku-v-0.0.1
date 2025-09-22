<x-filament::page>
    <div class="grid grid-cols-4 gap-4">
        @forelse($this->produks as $produk)
            <div class="border rounded-lg shadow p-3 bg-white">
                {{-- gambar produk --}}
                <img src="{{ asset('storage/'.$produk->img_produk) }}" 
                     class="w-full h-32 object-cover rounded">

                {{-- nama --}}
                <h4 class="font-semibold mt-2">{{ $produk->nama_produk }}</h4>

                {{-- harga --}}
                <p class="text-gray-600">
                    Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                </p>

                {{-- stok --}}
                <p class="text-sm text-gray-500">Stok: {{ $produk->stok_produk }}</p>

                {{-- tombol --}}
                <x-filament::button color="primary" class="mt-2 w-full">
                    Tambah
                </x-filament::button>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">
                Belum ada produk aktif
            </div>
        @endforelse
    </div>
</x-filament::page>
