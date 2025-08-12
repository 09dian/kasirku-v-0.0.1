<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
     use HasFactory;
    protected $fillable = [
        'kategori_produk',
        'nama_produk',
        'harga_produk',
        'stok_produk',
        'img_produk',
        'status',
    ];
}
