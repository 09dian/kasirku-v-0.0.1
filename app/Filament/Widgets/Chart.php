<?php

namespace App\Filament\Widgets;
use App\Models\History;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class Chart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';

    protected function getData(): array
    {
        // Cek apakah pakai SQLite
        $isSqlite = DB::getDriverName() === 'sqlite';

        // Ambil total harga per bulan
        $data = History::select(
                DB::raw($isSqlite
                    ? "strftime('%m', created_at) as bulan"
                    : "MONTH(created_at) as bulan"
                ),
                DB::raw('SUM(totalHarga) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Label bulan
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                   'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Susun data sesuai bulan
        $dataset = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = $isSqlite ? str_pad($i, 2, '0', STR_PAD_LEFT) : $i;
            $dataset[] = $data->firstWhere('bulan', $key)->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penghasilan',
                    'data' => $dataset,
                    'backgroundColor' => '#3b82f6', // biru
                    'borderColor' => '#1e40af',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
