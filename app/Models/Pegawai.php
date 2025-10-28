<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'idToko',
        'id_pegawai',
        'nama',
        'email',
        'no_telp',
        'jabatan',
        'alamat',
    ];
}
