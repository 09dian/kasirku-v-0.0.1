<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'namaPembeli',
        'genderPembeli',
        'idProduk',
        'namaProduk',
        'jumlahProduk',
        'harga',
        'totalHarga',
    ];
}
