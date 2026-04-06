<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    // Data seed dasar (Generate Default Admin Account)
    public function run(): void
    {
        User::create([
            'nis_nip' => 'admin',
            'name'    => 'Admin',
            'kelas'   => null,
            'password' => Hash::make('admin123'),
            'level'   => 'admin',
            'telp'    => '081234567890',
        ]);
    }
}
