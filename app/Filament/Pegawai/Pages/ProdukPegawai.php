<?php

namespace App\Filament\Pegawai\Pages;

use Filament\Pages\Page;

class ProdukPegawai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $title = 'Produk';
    protected static string $view = 'filament.pegawai.pages.produk-pegawai';
}
