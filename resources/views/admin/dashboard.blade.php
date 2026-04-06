<!-- Dashboard / Halaman Ringkasan Untuk Admin -->
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <!-- Ucapan Selamat Datang -->
    <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
        <h4 class="fw-bold m-0">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
        <p class="text-muted m-0">Berikut adalah ringkasan data aplikasi PRASLY hari ini.</p>
    </div>
    <!-- Waktu -->
    <div class="col-md-6 text-md-end text-center">
        <div class="d-inline-block px-4 py-2 bg-white shadow-sm rounded-pill fw-bold text-primary">
            <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
</div>

<!-- ==============================================
     Bagian Cards - Menampilkan Total / Jumlah Variabel
     ============================================== -->
<div class="row mb-4">
    <!-- Card Jumlah Daftar Siswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info me-3 shadow-sm"><i class="bi bi-people-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Total Siswa</h6>
                    <h3 class="fw-bold m-0 text-dark">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Jumlah Seluruh Laporan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary me-3 shadow-sm"><i class="bi bi-megaphone-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Total Pengaduan</h6>
                    <h3 class="fw-bold m-0 text-dark">{{ $totalPengaduan }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Card List Data Tabel Kategori -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning me-3 shadow-sm"><i class="bi bi-tags-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Kategori List</h6>
                    <h3 class="fw-bold m-0 text-dark">{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Tugas yang Sudah Beres (Selesai) -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success me-3 shadow-sm"><i class="bi bi-check-circle-fill"></i></div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Tugas Selesai</h6>
                    <h3 class="fw-bold m-0 text-dark">{{ $selesai }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- ==============================================
         Tabel Aktifitas Laporan Terbaru (Max 5 data table)
         ============================================== -->
    <div class="col-xl-8 mb-4">
        <div class="content-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold m-0"><i class="bi bi-clock-history me-2"></i>5 Pengaduan Terbaru</h6>
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduanTerbaru as $p)
                        <tr>
                            <!-- Relasi User -> Pengirim Laporan -->
                            <td>
                                <div class="fw-semibold">{{ $p->user->name }}</div>
                                <div class="text-muted" style="font-size: 0.8rem;">{{ $p->user->kelas ?? 'Siswa' }}</div>
                            </td>
                            <!-- Relasi Kategori -->
                            <td><span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">{{ $p->kategori->nama_kategori }}</span></td>
                            <!-- Indikasi lable Status -->
                            <td>{!! $p->status_label !!}</td>
                            <td>
                                <a href="{{ route('admin.pengaduan.detail', $p->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">Tanggapi</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada pengaduan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- ==============================================
         List Hitungan Breakdown Status Keluhan (Sidebar Box)
         ============================================== -->
    <div class="col-xl-4 mb-4">
        <div class="content-card h-100 bg-primary bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h6 class="fw-bold mb-4 border-bottom border-light pb-3 border-opacity-25"><i class="bi bi-pie-chart-fill me-2"></i>Status Pengaduan</h6>
            
            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white bg-opacity-10 rounded-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark rounded-circle p-2"><i class="bi bi-hourglass-split"></i></span>
                    <span class="fw-semibold">Menunggu</span>
                </div>
                <h4 class="m-0 fw-bold">{{ $menunggu }}</h4>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white bg-opacity-10 rounded-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info text-dark rounded-circle p-2"><i class="bi bi-gear-fill"></i></span>
                    <span class="fw-semibold">Proses</span>
                </div>
                <h4 class="m-0 fw-bold">{{ $proses }}</h4>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white bg-opacity-10 rounded-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success rounded-circle p-2"><i class="bi bi-check-circle-fill"></i></span>
                    <span class="fw-semibold">Selesai</span>
                </div>
                <h4 class="m-0 fw-bold">{{ $selesai }}</h4>
            </div>

            <div class="d-flex justify-content-between align-items-center p-3 bg-white bg-opacity-10 rounded-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger rounded-circle p-2"><i class="bi bi-x-circle-fill"></i></span>
                    <span class="fw-semibold">Ditolak</span>
                </div>
                <h4 class="m-0 fw-bold">{{ $ditolak }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection
