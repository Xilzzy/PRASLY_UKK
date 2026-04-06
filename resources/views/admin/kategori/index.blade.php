<!-- Tabel Setting Management Kategori Sarpras Untuk Dropdown -->
@extends('layouts.admin')

@section('title', 'Kategori Pengaduan')
@section('page-title', 'Tipe Laporan')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="fw-bold m-0"><i class="bi bi-tags-fill me-2"></i>Kategori</h5>
        <!-- Button Trigger Box Modal -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Buat Kategori
        </button>
    </div>

    <!-- DataTables Table Plugin -->
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Kategori</th>
                    <th width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori as $key => $k)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="fw-semibold">{{ $k->nama_kategori }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Toggle Buka Modal ID Per Kolom -->
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}" title="Perbaiki Typo">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Destroy Method Route Kategori -->
                            <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Peringatan: Seluruh Pengaduan yang terkait dengan Topik Kategori ini juga akan terhapus. Lanjutkan?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Clean All">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- ==============================================
                     MODAL RUBAH / RENAME TYPE (Within The Iterator Loop)
                     ============================================== -->
                <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 16px;">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Struktur Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.kategori.update', $k->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Label Baru</label>
                                        <input type="text" class="form-control" name="nama_kategori" value="{{ $k->nama_kategori }}" required style="border-radius: 10px;">
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Terapkan Info Baru</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ==============================================
     MODAL BIKIN RECORD TIPE BARU PADA DB
     ============================================== -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Spesifikasi Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Gaya Laporan</label>
                        <input type="text" class="form-control" name="nama_kategori" placeholder="Cth: Plafon Bocor" required style="border-radius: 10px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Push To List Area</button>
                </div>
            </form>
        </div>
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
