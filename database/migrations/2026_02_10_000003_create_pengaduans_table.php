<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Struktur pembuatan tabel 'pengaduans' untuk laporan keluhan
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            // Constraint hapus otomatis (cascade) dengan User & Kategori
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            
            $table->string('judul_laporan');
            $table->text('isi_laporan');
            $table->date('tgl_pengaduan');
            $table->string('foto')->nullable();
            
            // Status pengaduan (0: Tolak, 1: Menunggu, 2: Proses, 3: Selesai)
            $table->enum('status', ['0', '1', '2', '3'])->default('1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
