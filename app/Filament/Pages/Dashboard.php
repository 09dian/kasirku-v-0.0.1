<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Widgets\Widget;
use App\Filament\Widgets\Chart;
use App\Filament\Widgets\ProdukTerlaris;
use App\Filament\Widgets\ProdukHampirHabis;
use App\Filament\Widgets\Dashboard as StatsWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';
    protected static string $view = 'filament.pages.dashboard';

    /**
     * Tentukan widget apa saja yang ingin ditampilkan di dashboard ini
     */
    protected function getHeaderWidgets(): array
    {
        return [
            StatsWidget::class, // Statistik: penghasilan, barang, produk
        ];
    }
    

    protected function getFooterWidgets(): array
    {
        return [
            ProdukTerlaris::class, // Tabel produk terlaris
            Chart::class, // Chart penjualan
            ProdukHampirHabis::class, // Tabel produk hampir habis
        ];
    }
}
