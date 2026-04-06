<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Tampilkan daftar siswa
    public function index()
    {
        $siswa = User::where('level', 'siswa')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    // Simpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nis_nip'  => 'required|unique:users,nis_nip',
            'name'     => 'required|string|max:255',
            'kelas'    => 'nullable|string|max:50',
            'password' => 'required|min:6',
            'telp'     => 'nullable|string|max:20',
        ]);

        User::create([
            'nis_nip'  => $request->nis_nip,
            'name'     => $request->name,
            'kelas'    => $request->kelas,
            'password' => Hash::make($request->password), // Enkripsi password
            'level'    => 'siswa',
            'telp'     => $request->telp,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    // Update data siswa
    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'nis_nip'  => 'required|unique:users,nis_nip,' . $id,
            'name'     => 'required|string|max:255',
            'kelas'    => 'nullable|string|max:50',
            'telp'     => 'nullable|string|max:20',
        ]);

        $siswa->update([
            'nis_nip' => $request->nis_nip,
            'name'    => $request->name,
            'kelas'   => $request->kelas,
            'telp'    => $request->telp,
        ]);

        // Cek jika password diubah
        if ($request->filled('password')) {
            $siswa->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Hapus siswa
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
