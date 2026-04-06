<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    // Field yang bisa diisi
    protected $fillable = [
        'user_id', 'kategori_id', 'judul_laporan', 'isi_laporan', 'tgl_pengaduan', 'foto', 'status',
    ];

    // Relasi ke User pembuat pengaduan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi tanggapan yang dimiliki pengaduan ini
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }

    // Accessor: Ambil status sebagai elemen badge HTML ({!! $pengaduan->status_label !!})
    public function getStatusLabelAttribute()
    {
        $labels = [
            '0' => '<span class="badge bg-danger">Ditolak</span>',
            '1' => '<span class="badge bg-warning text-dark">Menunggu</span>',
            '2' => '<span class="badge bg-info text-dark">Proses</span>',
            '3' => '<span class="badge bg-success">Selesai</span>',
        ];
        return $labels[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
