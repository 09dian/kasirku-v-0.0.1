<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\History;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class ProdukTerlaris extends BaseWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    public function table(Table $table): Table
    {
        $query = History::select(
            DB::raw('idProduk as id'),
            'idProduk',
            'namaProduk',
            DB::raw('SUM(jumlahProduk) as totalTerjual'),
        )
            ->groupBy('idProduk', 'namaProduk')
            ->orderByDesc('totalTerjual')->limit(4);
        return $table->query($query)->columns([
            TextColumn::make('idProduk')->label('ID Produk'), 
        TextColumn::make('namaProduk')->label('Nama Produk')->searchable(), 
        TextColumn::make('totalTerjual')->label('Jumlah')]);
    }
}
