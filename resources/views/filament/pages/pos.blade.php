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
                        <div class="pos-card">
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
        <x-filament::card>
            latihan
        </x-filament::card>
    </div>

    @push('scripts')
        <script src="{{ asset('kasirku.js') }}"></script>
    @endpush
</x-filament::page>
