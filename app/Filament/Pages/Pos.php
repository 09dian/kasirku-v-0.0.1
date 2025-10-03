<?php

namespace App\Filament\Pages;

use App\Models\Produk;
use Filament\Pages\Page;

class Pos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string $view = 'filament.pages.pos';
    protected static ?string $title = 'Point of Sale';

    public $search = '';
    public $keranjang = [];
    public $invoice = null;

    public function getProduksProperty()
    {
        $search = $this->search;

        return Produk::query()
            ->where('status', 1)
            ->when($search, function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->get();
    }

    public function tambahKeranjang($produkId)
    {
        $produk = Produk::find($produkId);
        if (!$produk) {
            return;
        }

        $id = $produk->id;

        if (isset($this->keranjang[$id])) {
            $this->keranjang[$id]['qty']++;
        } else {
            $this->keranjang[$id] = [
                'id'    => $id,
                'nama'  => $produk->nama_produk,
                'harga' => $produk->harga_produk,
                'img'   => $produk->img_produk,
                'qty'   => 1,
            ];
        }

        // ✅ kalau belum ada invoice, generate otomatis
        if (!$this->invoice) {
            $this->invoice = $this->generateInvoice();
        }
    }

    public function plus($id)
    {
        if (isset($this->keranjang[$id])) {
            $this->keranjang[$id]['qty']++;
        }
    }

    public function minus($id)
    {
        if (isset($this->keranjang[$id])) {
            if ($this->keranjang[$id]['qty'] > 1) {
                $this->keranjang[$id]['qty']--;
            } else {
                unset($this->keranjang[$id]);
            }

            
            if (count($this->keranjang) === 0) {
                $this->invoice = null;
            }
        }
    }

    private function generateInvoice(): string
    {
        // 3 huruf random
        $huruf = '';
        for ($i = 0; $i < 3; $i++) {
            $huruf .= chr(rand(65, 90)); // A-Z
        }

        // format tanggal: ddmmyy
        $tanggal = now()->format('dmy');

        return $huruf . $tanggal;
    }
}
