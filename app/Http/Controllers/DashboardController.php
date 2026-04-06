<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Kategori;

class DashboardController extends Controller
{
    // Dashboard untuk Admin (Semua data)
    public function admin()
    {
        $totalSiswa     = User::where('level', 'siswa')->count();
        $totalPengaduan = Pengaduan::count();
        $totalKategori  = Kategori::count();

        // Hitung pengaduan berdasarkan status
        $ditolak   = Pengaduan::where('status', '0')->count();
        $menunggu  = Pengaduan::where('status', '1')->count();
        $proses    = Pengaduan::where('status', '2')->count();
        $selesai   = Pengaduan::where('status', '3')->count();

        // Ambil 5 pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::with(['user', 'kategori'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalPengaduan', 'totalKategori',
            'ditolak', 'menunggu', 'proses', 'selesai',
            'pengaduanTerbaru'
        ));
    }

    // Dashboard untuk Siswa (Hanya data milik siswa tersebut)
    public function siswa()
    {
        $user = auth()->user();

        // Filter riwayat hanya untuk siswa yang login
        $totalPengaduan = Pengaduan::where('user_id', $user->id)->count();

        $ditolak  = Pengaduan::where('user_id', $user->id)->where('status', '0')->count();
        $menunggu = Pengaduan::where('user_id', $user->id)->where('status', '1')->count();
        $proses   = Pengaduan::where('user_id', $user->id)->where('status', '2')->count();
        $selesai  = Pengaduan::where('user_id', $user->id)->where('status', '3')->count();

        $pengaduanTerbaru = Pengaduan::with(['kategori'])->where('user_id', $user->id)->latest()->take(5)->get();

        return view('siswa.dashboard', compact(
            'totalPengaduan', 'ditolak', 'menunggu', 'proses', 'selesai',
            'pengaduanTerbaru'
        ));
    }
}
