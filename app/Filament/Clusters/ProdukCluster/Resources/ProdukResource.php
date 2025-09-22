<?php

namespace App\Filament\Clusters\ProdukCluster\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use Filament\Forms\Get;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Clusters\ProdukCluster;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\ProdukCluster\Resources\ProdukResource\Pages;
use App\Filament\Clusters\ProdukCluster\Resources\ProdukResource\RelationManagers;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $cluster = ProdukCluster::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('kategori_produk')
                ->label('Kategori Produk')
                ->options(Category::where('status', 1)->pluck('name_category', 'name_category')->toArray())
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('nama_produk')->required(),
            Forms\Components\TextInput::make('harga_produk')->required(),
            Forms\Components\TextInput::make('stok_produk')->required(),
            FileUpload::make('img_produk')->label('Gambar Produk')->image()->required(),
            Toggle::make('status')
                ->label(fn(Get $get) => $get('status') ? 'Aktif' : 'Tidak Aktif')
                ->onColor('success')
                ->offColor('danger')
                ->live() // supaya label berubah langsung saat diubah
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([TextColumn::make('nama_produk')->label('Nama Produk')->searchable()->sortable(), TextColumn::make('harga_produk')->label('Harga Produk')->searchable()->sortable(), TextColumn::make('stok_produk')->label('Stok Produk')->searchable()->sortable(), TextColumn::make('kategori_produk')->label('Kategori Produk')->searchable()->sortable(), ImageColumn::make('img_produk')->label('Gambar Produk')->disk('public')->getStateUsing(fn($record) => $record->img_produk ?: 'no-image.png')->size(80), IconColumn::make('status')->boolean()])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
