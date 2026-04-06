<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // ==========================================
    // BAGIAN ADMIN
    // ==========================================

    // Tampilkan semua pengaduan
    public function adminIndex()
    {
        $pengaduan = Pengaduan::with(['user', 'kategori'])->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    // Detail pengaduan untuk admin
    public function adminDetail($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori', 'tanggapan.user'])->findOrFail($id);
        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    // Ubah status pengaduan
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $request->validate(['status' => 'required|in:0,1,2,3']);
        $pengaduan->update(['status' => $request->status]);

        return redirect()->route('admin.pengaduan.detail', $id)->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    // Tambah tanggapan dari admin
    public function storeTanggapan(Request $request, $id)
    {
        $request->validate(['tanggapan' => 'required|string']);

        Tanggapan::create([
            'pengaduan_id'  => $id,
            'user_id'       => auth()->id(),
            'tgl_tanggapan' => now()->toDateString(),
            'tanggapan'     => $request->tanggapan,
        ]);

        return redirect()->route('admin.pengaduan.detail', $id)->with('success', 'Tanggapan berhasil dikirim.');
    }

    // ==========================================
    // BAGIAN SISWA
    // ==========================================

    // Tampilkan daftar pengaduan milik siswa login
    public function siswaIndex()
    {
        $pengaduan = Pengaduan::with(['kategori'])->where('user_id', auth()->id())->latest()->get();
        return view('siswa.pengaduan.index', compact('pengaduan'));
    }

    // Halaman tambah pengaduan
    public function create()
    {
        $kategori = Kategori::all();
        return view('siswa.pengaduan.create', compact('kategori'));
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'   => 'required|exists:kategoris,id',
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan'   => 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/pengaduan'), $fotoName);
            $fotoPath = $fotoName;
        }

        Pengaduan::create([
            'user_id'       => auth()->id(),
            'kategori_id'   => $request->kategori_id,
            'judul_laporan' => $request->judul_laporan,
            'isi_laporan'   => $request->isi_laporan,
            'tgl_pengaduan' => now()->toDateString(),
            'foto'          => $fotoPath,
            'status'        => '1', // Status awal: Menunggu
        ]);

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Detail pengaduan untuk siswa (hanya miliknya sendiri)
    public function siswaDetail($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'tanggapan.user'])->where('user_id', auth()->id())->findOrFail($id);
        return view('siswa.pengaduan.detail', compact('pengaduan'));
    }

    // Halaman edit pengaduan
    public function edit($id)
    {
        $pengaduan = Pengaduan::where('user_id', auth()->id())->findOrFail($id);
        $kategori = Kategori::all();
        return view('siswa.pengaduan.edit', compact('pengaduan', 'kategori'));
    }

    // Update pengaduan
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'kategori_id'   => 'required|exists:kategoris,id',
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan'   => 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['kategori_id', 'judul_laporan', 'isi_laporan']);

        // Ganti foto bila ada unggahan baru
        if ($request->hasFile('foto')) {
            if ($pengaduan->foto && file_exists(public_path('uploads/pengaduan/' . $pengaduan->foto))) {
                unlink(public_path('uploads/pengaduan/' . $pengaduan->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/pengaduan'), $fotoName);
            $data['foto'] = $fotoName;
        }

        $pengaduan->update($data);

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // Hapus pengaduan
    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('user_id', auth()->id())->findOrFail($id);

        if ($pengaduan->foto && file_exists(public_path('uploads/pengaduan/' . $pengaduan->foto))) {
            unlink(public_path('uploads/pengaduan/' . $pengaduan->foto));
        }

        $pengaduan->delete();

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
