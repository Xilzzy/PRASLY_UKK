<!-- Form Tambah Laporan Pengaduan Baru Oleh Siswa -->
@extends('layouts.siswa')

@section('title', 'Buat Pengaduan')
@section('page-title', 'Buat Pengaduan Baru')

@section('content')
<div class="content-card">
    <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle-fill me-2"></i>Form Pengaduan Baru</h5>

    <form action="{{ route('siswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Dropdown Pilihan Kategori Berdasarkan List di Database -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select class="form-select" name="kategori_id" required style="border-radius: 10px;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Input Text Biasa -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Judul Laporan</label>
                <input type="text" class="form-control" name="judul_laporan" value="{{ old('judul_laporan') }}" required placeholder="Masukkan judul" style="border-radius: 10px;">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Isi Laporan</label>
            <textarea class="form-control" name="isi_laporan" rows="5" required placeholder="Jelaskan detail pengaduan..." style="border-radius: 10px;">{{ old('isi_laporan') }}</textarea>
        </div>

        <!-- Input File Gambar Lampiran Laporan (Opsional) -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Foto (opsional)</label>
            <input type="file" class="form-control" name="foto" accept="image/jpeg,image/png,image/jpg" style="border-radius: 10px;">
            <div class="form-text text-muted"><i class="bi bi-info-circle me-1"></i>Format: JPG, JPEG, PNG. Max 2MB.</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('siswa.pengaduan.index') }}" class="btn btn-secondary" style="border-radius: 10px;"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;"><i class="bi bi-send-fill me-1"></i> Kirim</button>
        </div>
    </form>
</div>
@endsection
