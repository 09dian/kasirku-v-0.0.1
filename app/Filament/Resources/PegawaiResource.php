<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationGroup = 'Other';

    protected static ?string $navigationLabel = 'Pegawai';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    private static function generateIdPegawai(): string
    {
        // huruf acak A-Z (2 karakter)
        $idPegawai = '';
        for ($i = 0; $i < 2; $i++) {
            $idPegawai .= chr(rand(65, 90));
        }

        // format tanggal: ddmmyy
        $tanggal = now()->format('dmy');

        return $idPegawai . $tanggal;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Hidden::make('idToko')
                ->required()
                ->default(auth()->id()), //bagian ini hilang untuk tampilannya
             Forms\Components\TextInput::make('id_pegawai')
                ->required()->readOnly()
                ->default(fn() => self::generateIdPegawai()),
            Forms\Components\TextInput::make('nama')->required(),
            Forms\Components\TextInput::make('email')->required(),
            Forms\Components\TextInput::make('no_telp')->required(),
            Forms\Components\TextInput::make('jabatan')->required(),
            Forms\Components\TextInput::make('alamat')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('id_pegawai')->searchable(), Tables\Columns\TextColumn::make('nama')->searchable(), Tables\Columns\TextColumn::make('email')->searchable(), Tables\Columns\TextColumn::make('no_telp')->searchable(), Tables\Columns\TextColumn::make('jabatan')->searchable(), Tables\Columns\TextColumn::make('alamat')->searchable(), Tables\Columns\TextColumn::make('nama')->searchable()])
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
