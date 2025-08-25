<x-filament::page>
    
    <div class="grid grid-cols-4 gap-4">
        @foreach($this->produks as $produk)
            <div class="border rounded-lg shadow p-3 bg-white">
                <img src="{{ asset('storage/'.$produk->img_produk) }}" class="w-full h-32 object-cover rounded">
                <h4 class="font-semibold mt-2">{{ $produk->nama_produk }}</h4>
                <p class="text-gray-600">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">Stok: {{ $produk->stok_produk }}</p>
                <x-filament::button color="primary" class="mt-2 w-full">
                    Tambah
                </x-filament::button>
            </div>
        @endforeach
    </div>
</x-filament::page>
