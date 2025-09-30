<?php

namespace App\Filament\Pages;

use App\Models\Produk;
use Filament\Pages\Page;

class Pos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string $view = 'filament.pages.pos';
    protected static ?string $title = 'Point of Sale';

    public $search = ''; // untuk wire:model dari input

    
    public function getProduksProperty()
    {
        $search = $this->search; // ambil dulu ke variabel biasa

        return Produk::query()
            ->where('status', 1)
            ->when($search, function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->get();
    }
}
