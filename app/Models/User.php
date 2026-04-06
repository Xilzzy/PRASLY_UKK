<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'nis_nip', 'name', 'kelas', 'password', 'level', 'telp',
    ];


    protected $hidden = [
        'password',
    ];


    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }


    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }
}
