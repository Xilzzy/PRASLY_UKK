<!-- Menampilkan Detail Pengaduan + Reply Read-Only Admin  -->
@extends('layouts.siswa')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan Saya')

@section('styles')
<style>
    /* Styling List Tanggapan dari Admin Sidebar */
    .feedback-card {
        background: #f8fafc; border-left: 4px solid #3b82f6; 
        border-radius: 0 12px 12px 0; padding: 15px 20px; margin-bottom: 12px;
    }
    .feedback-card .feedback-author { font-weight: 600; color: #1e293b; font-size: 0.9rem; }
    .feedback-card .feedback-date { font-size: 0.75rem; color: #94a3b8; }
    .feedback-card .feedback-text { margin-top: 8px; color: #475569; line-height: 1.6; }
</style>
@endsection

@section('content')
<div class="mb-3 d-flex gap-2">
    <a href="{{ route('siswa.pengaduan.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    
    @if($pengaduan->status == '1')
        <a href="{{ route('siswa.pengaduan.edit', $pengaduan->id) }}" class="btn btn-primary" style="border-radius: 10px;">
            <i class="bi bi-pencil me-1"></i> Edit Laporan
        </a>
    @endif
</div>

<div class="row">
    <!-- PANEL KIRI: INFO PENGADUAN -->
    <div class="col-lg-7">
        <div class="content-card mb-4 mb-lg-0">
            <h5 class="fw-bold mb-3"><i class="bi bi-file-text me-2"></i>Rincian Laporan</h5>

            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Dibuat Pada</div>
                <div class="col-sm-8">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d F Y') }}</div>
            </div>
            <!-- Relasi Kategori & Laporan -->
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Kategori</div>
                <div class="col-sm-8"><span class="badge bg-info text-dark">{{ $pengaduan->kategori->nama_kategori }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Judul</div>
                <div class="col-sm-8 fw-bold">{{ $pengaduan->judul_laporan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Isi Detail</div>
                <div class="col-sm-8" style="line-height: 1.8;">{{ $pengaduan->isi_laporan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Status Progres</div>
                <div class="col-sm-8">{!! $pengaduan->status_label !!}</div>
            </div>

            <!-- Tampilkan foto relasi public id -->
            @if($pengaduan->foto)
            <div class="row mb-3">
                <div class="col-sm-4 fw-semibold text-muted">Lampiran</div>
                <div class="col-sm-8">
                    <img src="{{ asset('uploads/pengaduan/' . $pengaduan->foto) }}" alt="Foto" class="img-fluid rounded shadow-sm" style="max-height: 250px; border-radius: 12px !important; cursor: pointer;" onclick="window.open(this.src)">
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- PANEL KANAN: TANGGAPAN ADMIN (Pesan Balasan Sifat: Read Only) -->
    <div class="col-lg-5">
        <div class="content-card">
            <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-text-fill me-2 text-primary"></i>Balasan Admin ({{ $pengaduan->tanggapan->count() }})</h6>

            @forelse($pengaduan->tanggapan as $t)
                <div class="feedback-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="feedback-author text-primary"><i class="bi bi-person-fill-check me-1"></i>{{ $t->user->name }} (Admin)</span>
                        <span class="feedback-date">{{ \Carbon\Carbon::parse($t->tgl_tanggapan)->format('d/m/Y') }}</span>
                    </div>
                    <div class="feedback-text">{{ $t->tanggapan }}</div>
                </div>
            @empty
                <!-- Tidak Ada Interaksi/Belum dibalas -->
                <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-square-dots" style="font-size: 2.5rem; opacity: 0.5;"></i>
                    <p class="mt-2">Belum ada tanggapan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
