<!-- Menampilkan Detail Laporan dan Tanggapan Admin -->
@extends('layouts.admin')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')

@section('styles')
<style>
    .feedback-card {
        background: #f8fafc; border-left: 4px solid #667eea;
        border-radius: 0 12px 12px 0; padding: 15px 20px; margin-bottom: 12px;
    }
    .feedback-card .feedback-author { font-weight: 600; color: #1e293b; font-size: 0.9rem; }
    .feedback-card .feedback-date { font-size: 0.75rem; color: #94a3b8; }
    .feedback-card .feedback-text { margin-top: 8px; color: #475569; line-height: 1.6; }
</style>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- PANEL KIRI: INFO DETAIL PENGADUAN -->
    <div class="col-lg-7">
        <div class="content-card">
            <h5 class="fw-bold mb-3"><i class="bi bi-file-text me-2"></i>Detail Pengaduan</h5>

            <!-- Data Relasi User Pengirim -->
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Pelapor</div>
                <div class="col-sm-8">{{ $pengaduan->user->name }} <span class="badge bg-primary">{{ $pengaduan->user->nis_nip }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Kelas</div>
                <div class="col-sm-8">{{ $pengaduan->user->kelas ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Tanggal</div>
                <div class="col-sm-8">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d F Y') }}</div>
            </div>
            <!-- Keluhan Laporan -->
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Kategori</div>
                <div class="col-sm-8"><span class="badge bg-info text-dark">{{ $pengaduan->kategori->nama_kategori }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Judul Laporan</div>
                <div class="col-sm-8 fw-bold">{{ $pengaduan->judul_laporan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Isi Laporan</div>
                <div class="col-sm-8" style="line-height: 1.8;">{{ $pengaduan->isi_laporan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Status</div>
                <div class="col-sm-8">{!! $pengaduan->status_label !!}</div>
            </div>

            <!-- Tampilkan View Gambar Lampiran -->
            @if($pengaduan->foto)
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Foto</div>
                <div class="col-sm-8">
                    <img src="{{ asset('uploads/pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="img-fluid rounded" style="max-height: 300px; border-radius: 12px !important; cursor: pointer;" onclick="window.open(this.src)">
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- PANEL KANAN: AKSI FORM STATUS & TANGGAPAN ADMIN -->
    <div class="col-lg-5">

        <!-- Kotak Edit Status -->
        <div class="content-card mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-arrow-repeat me-2"></i>Update Status</h6>
            <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Value tombol yang di submit berdasarkan form PUT -->
                    <button type="submit" name="status" value="0" class="btn btn-danger {{ $pengaduan->status == '0' ? 'active' : '' }}" style="border-radius: 10px;" onclick="return confirm('Tolak pengaduan ini?')">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    <button type="submit" name="status" value="1" class="btn btn-warning {{ $pengaduan->status == '1' ? 'active' : '' }}" style="border-radius: 10px;">
                        <i class="bi bi-hourglass-split"></i> Menunggu
                    </button>
                    <button type="submit" name="status" value="2" class="btn btn-info {{ $pengaduan->status == '2' ? 'active' : '' }}" style="border-radius: 10px;">
                        <i class="bi bi-gear-fill"></i> Proses
                    </button>
                    <button type="submit" name="status" value="3" class="btn btn-success {{ $pengaduan->status == '3' ? 'active' : '' }}" style="border-radius: 10px;">
                        <i class="bi bi-check-circle"></i> Selesai
                    </button>
                </div>
            </form>
        </div>

        <!-- Tambah Tanggapan Komentar -->
        <div class="content-card mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-chat-dots-fill me-2"></i>Kirim Tanggapan</h6>
            <form action="{{ route('admin.pengaduan.tanggapan', $pengaduan->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="tanggapan" rows="4" required placeholder="Tulis pesan ke siswa..." style="border-radius: 12px;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">Kirim Tanggapan</button>
            </form>
        </div>

        <!-- List Riwayat Tanggapan -->
        <div class="content-card">
            <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-text-fill me-2"></i>Riwayat Tanggapan ({{ $pengaduan->tanggapan->count() }})</h6>
            @forelse($pengaduan->tanggapan as $t)
                <div class="feedback-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="feedback-author"><i class="bi bi-person-circle me-1"></i>{{ $t->user->name }}</span>
                        <span class="feedback-date">{{ \Carbon\Carbon::parse($t->tgl_tanggapan)->format('d/m/Y') }}</span>
                    </div>
                    <div class="feedback-text">{{ $t->tanggapan }}</div>
                </div>
            @empty
                <div class="text-center text-muted py-3">Belum ada tanggapan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
