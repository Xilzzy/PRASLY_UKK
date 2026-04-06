<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nis_nip')->unique(); // ID unik untuk login
            $table->string('name');
            $table->string('kelas')->nullable(); // Admin tidak punya kelas
            $table->string('password');
            $table->enum('level', ['admin', 'siswa']); // Hak akses
            $table->string('telp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
