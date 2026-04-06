<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Kategori keluhan yang disediakan untuk user
    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori bisa digunakan oleh banyak pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
