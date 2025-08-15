<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
         $jumlahProduk = Produk::count();
        return [
            Stat::make('Penghasilan', 'Rp. ' . number_format(1000000, 0, ',', '.'))
                ->description('32k peningkatan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 10, 8, 15, 20, 17, 25]), // data grafik kecil di bawah
            Stat::make('Jumlah Produk', $jumlahProduk)
                ->description($jumlahProduk < 100 ? 'Produk Hampir Habis' : 'Stok Aman')
                ->color($jumlahProduk < 100 ? 'danger' : 'success'),
            Stat::make('Barang Keluar', '100'),
        ];
    }
}
