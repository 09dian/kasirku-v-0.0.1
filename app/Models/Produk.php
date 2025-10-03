<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_produk', 'nama_produk', 'harga_produk', 'stok_produk', 'img_produk', 'status'];

    protected static function booted()
    {
        // Hapus gambar lama saat update
        static::updating(function ($produk) {
            if ($produk->isDirty('img_produk')) {
                $oldImage = $produk->getOriginal('img_produk'); // nama file lama
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });

        // Hapus gambar saat record dihapus
        static::deleting(function ($produk) {
            if ($produk->img_produk && Storage::disk('public')->exists($produk->img_produk)) {
                Storage::disk('public')->delete($produk->img_produk);
            }
        });
    }
}
