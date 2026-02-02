<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\ProdukPegawaiResource\Pages;
use App\Filament\Pegawai\Resources\ProdukPegawaiResource\RelationManagers;
use App\Models\ProdukPegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukPegawaiResource extends Resource
{
    protected static ?string $model = ProdukPegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdukPegawais::route('/'),
            'create' => Pages\CreateProdukPegawai::route('/create'),
            'edit' => Pages\EditProdukPegawai::route('/{record}/edit'),
        ];
    }
}
