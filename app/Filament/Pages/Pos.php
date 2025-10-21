<?php

namespace App\Filament\Pages;

use App\Models\Produk;
use App\Models\History;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class Pos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string $view = 'filament.pages.pos';
    protected static ?string $title = 'Point of Sale';

    public $search = '';
    public $keranjang = [];
    public $invoice = null;
    public $bayar = 0;
    public $nama = '';
    public $select = '';

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
            if ($this->keranjang[$id]['qty'] < (int) $produk->stok_produk) {
                $this->keranjang[$id]['qty']++;
            } else {
                session()->flash('error', 'Stok tidak cukup.');
            }
        } else {
            if ((int) $produk->stok_produk > 0) {
                $this->keranjang[$id] = [
                    'id' => $id,
                    'nama' => $produk->nama_produk,
                    'harga' => $produk->harga_produk,
                    'img' => $produk->img_produk,
                    'qty' => 1,
                ];
            } else {
                session()->flash('error', 'Produk habis stok.');
            }
        }

        if (!$this->invoice) {
            $this->invoice = $this->generateInvoice();
        }
    }

    public function hargaSatuan($id)
    {
        $produk = Produk::find($id);

        if ($produk) {
            return $produk->harga_produk;
        }

        return 0;
    }

    public function plus($id)
    {
        if (!isset($this->keranjang[$id])) {
            return;
        }

        $produk = Produk::find($id);
        if (!$produk) {
            return;
        }

        if ($this->keranjang[$id]['qty'] < (int) $produk->stok_produk) {
            $this->keranjang[$id]['qty']++;
        } else {
            Notification::make()->title('Stok Kurang')->danger()->send();
            return; // optional, supaya tidak ada aksi lain
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
    public function getTotalProperty()
    {
        return collect($this->keranjang)->sum(function ($item) {
            return $item['harga'] * $item['qty'];
        });
    }
    public function checkout()
    {
        // Pastikan ada data di keranjang
        if (count($this->keranjang) == 0) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Keranjang masih kosong!',
            ]);
            return;
        }

        // Pastikan pembayaran cukup
        if ($this->bayar < $this->total) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Jumlah bayar kurang!',
            ]);
            return;
        }

        // Simpan ke tabel History
        foreach ($this->keranjang as $item) {
            $harga = $this->hargaSatuan($item['id']);
            $jumlah = $item['qty'] ?? 1; // ambil dari key 'qty'
            $produk = Produk::find($item['id']);
            if (!$produk) {
                continue;
            } // skip kalau produk gak ketemu
            History::create([
                'invoice' => $this->invoice,
                'harga' => $harga,
                'namaPembeli' => $this->nama ?: 'Pembeli Umum',
                'genderPembeli' => $this->select ?: '-',
                'idProduk' => $item['id'],
                'namaProduk' => $produk->nama_produk,
                'jumlahProduk' => $jumlah,
                'totalHarga' => $harga * $jumlah,
            ]);
        }

        // (Opsional) bisa juga kamu simpan detail produk ke tabel lain, misal HistoryDetail kalau kamu mau buat nanti.
        foreach ($this->keranjang as $item) {
            $produk = Produk::find($item['id']);
            if ($produk) {
                $produk->stok_produk = max(0, $produk->stok_produk - $item['qty']);
                $produk->save();
            }
        }
        // Reset semua setelah checkout
        $this->keranjang = [];
        $this->bayar = 0;
        $this->nama = '';
        $this->select = '';
        $this->invoice = '';

        Notification::make()->title('Berhasil checkout')->success()->send();
    }
}
