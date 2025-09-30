<x-filament::page>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('kasirku.css') }}">
    @endpush

    <div class="pos-layout">
        {{-- Kolom kiri: produk + search --}}
        <div class="pos-products">
            {{-- Search --}}
            <div class="pos-search flex gap-2 w-full">
                <x-filament::input.wrapper class="flex-1">
                    <x-filament::input type="text" placeholder="Cari produk..." wire:model.live="search"
                        class="w-full" />
                </x-filament::input.wrapper>

                <x-filament::button color="primary">
                    SCAN
                </x-filament::button>
            </div>



            {{-- Grid produk --}}
            <div class="pos-grid grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                @forelse($this->produks as $produk)
                    <x-filament::card class="flex flex-col items-center p-2">
                        <img src="{{ asset('storage/' . $produk->img_produk) }}" alt="{{ $produk->nama_produk }}"
                            class="h-32 w-32 object-cover rounded-md mb-2">

                        <div class="text-center">
                            <div class="font-semibold text-sm truncate w-32">
                                {{ $produk->nama_produk }}
                            </div>
                            <div class="text-primary-600 font-bold">
                                Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                            </div>
                            <div class="text-gray-500 text-xs">
                                Stok: {{ $produk->stok_produk }}
                            </div>
                        </div>
                    </x-filament::card>
                @empty
                    <div class="col-span-4 text-center text-gray-500">
                        Belum ada produk aktif
                    </div>
                @endforelse
            </div>
        </div>


        {{-- Kolom kanan: keranjang belanja --}}
        <div class="pos-cart">
            <h3>Keranjang Belanja</h3>
            <ul class="cart-list">
                <li>Produk A - 2x</li>
                <li>Produk B - 1x</li>
            </ul>

            <div class="cart-total">
                Total: <strong>Rp 0</strong>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('kasirku.js') }}"></script>
    @endpush
</x-filament::page>
