<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Pegawai extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $table = 'pegawais';

    protected $fillable = [
        'idToko',
        'id_pegawai',
        'nama',
        'email',
        'password',
        'no_telp',
        'jabatan',
        'hakAkses',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] =
            \Hash::needsRehash($value)
                ? \Hash::make($value)
                : $value;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    //  Dipakai Filament
    public function getFilamentName(): string
    {
        return $this->nama;
    }

    //  Dipakai saat Filament cari $user->name
    public function getNameAttribute(): string
    {
        return $this->nama;
    }
}

?>
