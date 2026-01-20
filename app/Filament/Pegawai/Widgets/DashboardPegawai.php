<?php

namespace App\Filament\Pegawai\Widgets;

use App\Models\Produk;
use App\Models\History;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardPegawai extends BaseWidget
{
    

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Produk', Produk::count())->description('Total semua produk')->icon('heroicon-m-cube')->color('success'),

            Stat::make('Produk Terjual', 'Rp ' . number_format(History::sum('totalHarga'), 0, ',', '.'))
                ->description('Total produk terjual')
                ->icon('heroicon-m-shopping-cart')
                ->color('primary'),

            Stat::make('Barang keluar', History::sum('jumlahProduk'))->icon('heroicon-m-exclamation-triangle'),
        ];
    }

    public static function canView(): bool
    {
        return auth('pegawai')->check();
    }
}
