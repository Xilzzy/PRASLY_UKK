<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    // Data balasan komentar dari admin terhadap pengaduan
    protected $fillable = [
        'pengaduan_id', 'user_id', 'tgl_tanggapan', 'tanggapan',
    ];

    // Relasi: Tanggapan terkait dengan pengaduan apa
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Relasi: Tanggapan ini ditulis oleh siapa (admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
