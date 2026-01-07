<?php

namespace App\Filament\Pegawai\Widgets;

use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProdukHampirHabis extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlah = Produk::where('stok', '<=', 5)->count();

        return [
            Stat::make('Produk Hampir Habis', $jumlah)
                ->description('Stok ≤ 10')
                ->icon('heroicon-m-exclamation-triangle')
                ->color($jumlah < 10 ? 'danger' : 'success'),
        ];
    }

    public static function canView(): bool
    {
        return auth('pegawai')->check();
    }
}
