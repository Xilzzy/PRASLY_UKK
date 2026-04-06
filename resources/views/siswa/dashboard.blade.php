<!-- Dashboard / Beranda Siswa  -->
@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <!-- Header Ucapan & Tombol Pintas Pembuatan Keluhan Baru -->
    <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
        <h4 class="fw-bold m-0" style="color: #1e293b;">Halo, {{ auth()->user()->name }}! 👋</h4>
        <p class="text-muted m-0">Sampaikan keluhan sarana & prasarana sekolahmu di sini.</p>
    </div>
    <div class="col-md-6 text-md-end text-center flex-wrap gap-2 d-flex justify-content-md-end justify-content-center">
        <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary shadow-sm" style="border-radius: 10px;">
            <i class="bi bi-plus-circle-fill me-2"></i>Buat Laporan
        </a>
    </div>
</div>

<!-- ==============================================
     Statistik Cards (Hanya berdasarkan data ID milik user siswa ini)
     ============================================== -->
<div class="row mb-4">
    <!-- Semua form terhubung di controller menggunakan Count Query db -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-file-earmark-text-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.8rem;">TOTAL LAPORAN</h6>
                    <h3 class="fw-bold m-0" style="color: #1e293b;">{{ $totalPengaduan }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.8rem;">MENUNGGU</h6>
                    <h3 class="fw-bold m-0" style="color: #1e293b;">{{ $menunggu }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info me-3"><i class="bi bi-gear-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.8rem;">DIPROSES</h6>
                    <h3 class="fw-bold m-0" style="color: #1e293b;">{{ $proses }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success me-3"><i class="bi bi-check-circle-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.8rem;">SELESAI</h6>
                    <h3 class="fw-bold m-0" style="color: #1e293b;">{{ $selesai }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- ==============================================
         Tabel Mini Log Aktivitas Maksimal 5 Data Terakhir 
         ============================================== -->
    <div class="col-xl-12 mb-4">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold m-0" style="color: #1e293b;"><i class="bi bi-clock-history me-2"></i>Aktivitas Pengaduan Terbaru</h6>
                <a href="{{ route('siswa.pengaduan.index') }}" class="btn btn-sm btn-light fw-semibold" style="border-radius: 8px; color: #3b82f6;">Lihat Semua</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">Tanggal</th>
                            <th>Judul Laporan</th>
                            <th width="20%">Kategori</th>
                            <th width="15%">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduanTerbaru as $p)
                        <tr>
                            <td class="text-muted" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d/m/Y') }}</td>
                            <td class="fw-semibold" style="color: #334155;">{{ Str::limit($p->judul_laporan, 40) }}</td>
                            <!-- Relasi Nama Kategori Badge Info -->
                            <td><span class="badge bg-light text-secondary border">{{ $p->kategori->nama_kategori }}</span></td>
                            <!-- Variabel HTML Badge Status -->
                            <td>{!! $p->status_label !!}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.pengaduan.detail', $p->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <!-- Tampilan Default Jika Database Laporan Kosong -->
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                Belum ada pengaduan. Ayo buat laporan pertamamu!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
