<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProdukHampirHabis extends BaseWidget
{
    protected static ?string $heading = 'Produk Hampir Habis';
     protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2; // urutan di dashboard (boleh ubah sesuai kebutuhan)

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produk::query()
                    ->where('stok_produk', '<', 5) // ambil produk dengan stok < 5
                    ->orderBy('stok', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok_produk')
                    ->label('Stok')
                    ->sortable()
                    ->color(fn ($record) => $record->stok <= 2 ? 'danger' : 'warning'),

                Tables\Columns\TextColumn::make('kategori_produk')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i'),
            ]);
    }
}
