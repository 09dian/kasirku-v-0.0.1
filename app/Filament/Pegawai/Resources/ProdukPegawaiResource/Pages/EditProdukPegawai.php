<?php

namespace App\Filament\Pegawai\Resources\ProdukPegawaiResource\Pages;

use App\Filament\Pegawai\Resources\ProdukPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukPegawai extends EditRecord
{
    protected static string $resource = ProdukPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
