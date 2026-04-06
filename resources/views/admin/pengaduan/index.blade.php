<!-- Tabel Main View Admin Penampung Keluhan dari Siswa Berbagai Kelas -->
@extends('layouts.admin')

@section('title', 'Semua Pengaduan')
@section('page-title', 'Tinjauan Masalah Global')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="fw-bold m-0"><i class="bi bi-megaphone-fill me-2"></i>History Laporan</h5>
    </div>

    <!-- DataTables Table Plugin -->
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">Tanggal</th>
                    <th width="10%">NIS</th>
                    <th width="15%">Nama Siswa</th>
                    <th width="10%">Kelas</th>
                    <th>Keluhan</th>
                    <th width="10%">Kategori</th>
                    <th width="10%">Status</th>
                    <th width="10%" class="text-center">Respons</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduan as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d/m/Y') }}</td>
                    
                    <!-- Relasi Field dari Table User Database -->
                    <td><span class="badge bg-secondary">{{ $p->user->nis_nip }}</span></td>
                    <td class="fw-semibold">{{ $p->user->name }}</td>
                    <td>{{ $p->user->kelas ?? '-' }}</td>
                    
                    <td>{{ Str::limit($p->judul_laporan, 30) }}</td>
                    
                    <!-- Relasi Field dari Table Kategori DB -->
                    <td><span class="badge bg-info text-dark">{{ $p->kategori->nama_kategori }}</span></td>
                    
                    <!-- Label Accessor -> app/Models/Pengaduan -->
                    <td>{!! $p->status_label !!}</td>
                    
                    <td class="text-center">
                        <!-- Redirect Aksi Menuju Panel Tanggapi (Read & Reply Admin Sidebar) -->
                        <a href="{{ route('admin.pengaduan.detail', $p->id) }}" class="btn btn-sm btn-primary" style="border-radius: 8px;">
                            <i class="bi bi-reply-fill"></i> Tanggapi   
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Plugin Init
    $(document).ready(function() {
        $('.datatable').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' } });
    });
</script>
@endsection
