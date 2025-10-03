<x-filament::page>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('kasirku.css') }}">
    @endpush

    <div class="pos-layout">
        {{-- Kolom kiri: produk + search --}}
        <div class="pos-products">

            <x-filament::card>
                <div class="pos-search flex gap-2">
                    <x-filament::input.wrapper class="flex-1">
                        <x-filament::input type="text" placeholder="Cari produk..." wire:model.live="search"
                            class="w-full" />
                    </x-filament::input.wrapper>

                    <x-filament::button color="primary" class="btn-scan">
                        SCAN
                    </x-filament::button>
                </div>
                <div class="pos-grid">
                    @forelse($this->produks as $produk)
                        <div wire:click="tambahKeranjang({{ $produk->id }})" class="pos-card">
                            <img src="{{ asset('storage/' . $produk->img_produk) }}" alt="{{ $produk->nama_produk }}">
                            <div class="pos-content">
                                <div class="pos-title">
                                    {{ $produk->nama_produk }}
                                </div>
                                <div class="pos-info harga">
                                    Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                </div>
                                <div class="pos-info">
                                    Stok: {{ $produk->stok_produk }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-produk">
                            <p>Belum ada produk aktif</p>
                            <img src="{{ asset('img/search.svg') }}" alt="search not found">
                        </div>
                    @endforelse
                </div>

            </x-filament::card>

        </div>

        {{-- Kolom kanan: keranjang belanja --}}
        <x-filament::card class="flex flex-col justify-between">
            <div class="head text-center">
                @if (count($this->keranjang) > 0)
                    <div class="font-semibold text-lg mb-3">
                        Invoice : {{ $this->invoice }}
                    </div>
                @endif
                <hr class="border-t border-gray-400 my-2 w-full">
            </div>

            <div class="keranjang-list space-y-3 mt-4 flex-1">
                @forelse($keranjang as $item)
                    <div
                        class="keranjang rounded-lg border shadow-sm dark:bg-gray-900 dark:border-gray-700 p-4 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $item['img']) }}" alt="{{ $item['nama'] }}"
                            class="w-20 h-20 object-cover rounded">

                        <div class="cart-info flex-1">
                            <div class="name font-semibold">{{ $item['nama'] }}</div>
                            <div class="pos-info text-gray-700">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="cart-qty flex items-center gap-2">
                            <button wire:click="minus({{ $item['id'] }})"
                                class="minus px-2 py-1 border rounded">-</button>
                            <span>{{ $item['qty'] }}</span>
                            <button wire:click="plus({{ $item['id'] }})"
                                class="plus px-2 py-1 border rounded">+</button>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center">Keranjang masih kosong</div>
                @endforelse
            </div>

            @if (count($this->keranjang) > 0)
                <x-filament::button color="primary" class="w-full mt-6">
                    Checkout
                </x-filament::button>
            @endif

        </x-filament::card>


    </div>

    @push('scripts')
        <script src="{{ asset('kasirku.js') }}"></script>
    @endpush
</x-filament::page>
