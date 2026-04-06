<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Struktur pembuatan tabel 'tanggapans' untuk umpan balik Admin
    public function up(): void
    {
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id();
            // Terhubung dengan pengaduan spesifik & admin yang ngirim
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tgl_tanggapan');
            $table->text('tanggapan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};
