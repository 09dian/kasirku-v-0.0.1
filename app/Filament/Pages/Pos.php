<?php
namespace App\Filament\Pages;

use App\Models\Produk;
use Filament\Pages\Page;

class Pos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string $view = 'filament.pages.pos';
    protected static ?string $title = 'Point of Sale';

    public $produks;

    public function mount()
    {
        $this->produks = Produk::where('status', 'active')->get();
    }
}
