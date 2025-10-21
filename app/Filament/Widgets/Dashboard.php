<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\History;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahProduk = Produk::count();
       

        $kemarin = History::whereDate('created_at', Carbon::yesterday())->sum('totalHarga');
        $hariIni = History::whereDate('created_at', Carbon::today())->sum('totalHarga');
        $penghasilan = History::sum('totalHarga');
        $barangKeluar = History::sum('jumlahProduk');


        $selisih = $hariIni - $kemarin;

        // Chart hanya menampilkan penghasilan kemarin
        $chartData = [$kemarin];

        return [
            Stat::make('Penghasilan', 'Rp. ' . number_format($penghasilan, 0, ',', '.'))
                ->description('Perbedaan dari kemarin: ' . number_format($selisih, 0, ',', '.'))
                ->descriptionIcon($selisih >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($selisih >= 0 ? 'success' : 'danger')
                ->chart($chartData),

            Stat::make('Jumlah Produk', $jumlahProduk),
            Stat::make('Barang Keluar', $barangKeluar),
        ];
    }
}
