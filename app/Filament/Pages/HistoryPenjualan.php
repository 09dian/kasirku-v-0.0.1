<?php

namespace App\Filament\Pages;

use App\Models\History;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class HistoryPenjualan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'History Penjualan';
    protected static ?string $navigationGroup = 'Other';
    protected static ?string $title = 'History Penjualan';
    protected static string $view = 'filament.pages.history-penjualan';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                History::query()->latest() // lebih ringkas dari orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('invoice')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('namaPembeli')
                    ->label('Nama Pembeli')
                    ->searchable(),

                Tables\Columns\TextColumn::make('genderPembeli')
                    ->label('Gender')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('totalHarga')
                    ->label('Total Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(true);
    }
}
