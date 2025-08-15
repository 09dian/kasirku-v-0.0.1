<?php

namespace App\Filament\Clusters\ProdukCluster\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Clusters\ProdukCluster;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\ProdukCluster\Resources\CategoryResource\Pages;
use App\Filament\Clusters\ProdukCluster\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ProdukCluster::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name_category')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug_category', str($state)->slug());
                }),
            Forms\Components\TextInput::make('slug_category')->required(),
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
            ->columns([Tables\Columns\TextColumn::make('name_category')->searchable(), Tables\Columns\TextColumn::make('slug_category')->searchable(), IconColumn::make('status')->boolean()])
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
