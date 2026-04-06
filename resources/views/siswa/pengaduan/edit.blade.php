<!-- Form Edit Laporan Pengaduan Siswa -->
@extends('layouts.siswa')

@section('title', 'Edit Pengaduan')
@section('page-title', 'Edit Pengaduan')

@section('content')
<div class="content-card">
    <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Pengaduan</h5>

    <form action="{{ route('siswa.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT') <!-- Wajib Put Request Update Method -->

        <div class="row">
            <!-- Selected dropdown List -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select class="form-select" name="kategori_id" required style="border-radius: 10px;">
                    <option value="">-- Pilih --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ $pengaduan->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Judul Laporan</label>
                <input type="text" class="form-control" name="judul_laporan" value="{{ $pengaduan->judul_laporan }}" required style="border-radius: 10px;">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Isi Laporan</label>
            <textarea class="form-control" name="isi_laporan" rows="5" required style="border-radius: 10px;">{{ $pengaduan->isi_laporan }}</textarea>
        </div>

        <!-- Render Foto Saat Ini lalu tambahkan Input jika ingin merubah value image table/directory server -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Foto Saat Ini</label><br>
            @if($pengaduan->foto)
                <img src="{{ asset('uploads/pengaduan/' . $pengaduan->foto) }}" alt="Foto" class="img-thumbnail mb-2" style="max-height: 200px; border-radius: 10px;">
            @else
                <p class="text-muted fst-italic">Tidak ada foto</p>
            @endif

            <label class="form-label fw-semibold mt-2">Ganti Foto (Kosongkan bila sama)</label>
            <input type="file" class="form-control" name="foto" accept="image/jpeg,image/png,image/jpg" style="border-radius: 10px;">
        </div>

        <!-- Action Batal/Update -->
        <div class="d-flex gap-2">
            <a href="{{ route('siswa.pengaduan.index') }}" class="btn btn-secondary" style="border-radius: 10px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Update Laporan</button>
        </div>
    </form>
</div>
@endsection
