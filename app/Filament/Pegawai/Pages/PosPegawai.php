<?php

namespace App\Filament\Pegawai\Pages;

use Filament\Pages\Page;

class PosPegawai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $title = 'Point of Sale';
    protected static string $view = 'filament.pegawai.pages.pos-pegawai';
}
