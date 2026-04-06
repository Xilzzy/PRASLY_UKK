<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Field yang bisa diisi lewat form create/update
    protected $fillable = [
        'nis_nip', 'name', 'kelas', 'password', 'level', 'telp',
    ];

    // Field yang disembunyikan jika di-convert ke array/JSON
    protected $hidden = [
        'password',
    ];

    // Konversi tipe data kolom secara otomatis
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Auto enkripsi password
        ];
    }

    // Relasi: Satu user bisa memiliki banyak pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    // Relasi: Satu user (admin) bisa memberi banyak tanggapan
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }
}
