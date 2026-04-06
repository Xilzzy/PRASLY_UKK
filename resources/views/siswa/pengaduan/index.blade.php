<!-- Tabel List Keluhan Khusus User yang login -->
@extends('layouts.siswa')

@section('title', 'Data Pengaduan')
@section('page-title', 'Pengaduan Saya')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="fw-bold m-0"><i class="bi bi-list-task me-2"></i>Daftar Laporan Anda</h5>
        <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Buat Laporan
        </a>
    </div>

    <!-- DataTables Table Plugin History Laporan -->
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th>Judul Laporan</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Status</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduan as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d/m/Y') }}</td>
                    <td class="fw-semibold">{{ Str::limit($p->judul_laporan, 30) }}</td>
                    <!-- Relasi Label -->
                    <td><span class="badge bg-info text-dark">{{ $p->kategori->nama_kategori }}</span></td>
                    <td>{!! $p->status_label !!}</td>
                    
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <!-- Detail Laporan / Baca Feedback Chat Log Admin -->
                            <a href="{{ route('siswa.pengaduan.detail', $p->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Edit dan Hapus Laporan HANYA BERLAKU JIKA STATUS Laporan Masih Belum Diupdate/Diproses -->
                            @if($p->status == '1')
                                <a href="{{ route('siswa.pengaduan.edit', $p->id) }}" class="btn btn-sm btn-outline-secondary" title="Revisi">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('siswa.pengaduan.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Batalkan/Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <!-- Data Empty -->
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada laporan yang dibuat.</td>
                </tr>
                @endforelse
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
