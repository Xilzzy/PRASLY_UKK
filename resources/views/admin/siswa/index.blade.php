<!-- Tabel Menampilkan Daftar Seluruh User Siswa -->
@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page-title', 'Manajemen Siswa')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="fw-bold m-0"><i class="bi bi-people-fill me-2"></i>Daftar Anggota / Siswa</h5>
        <!-- Trigger Modal Form Tambah Data Row Siswa -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
        </button>
    </div>

    <!-- DataTables Table Plugin -->
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>No. Telepon</th>
                    <th width="15%" class="text-center">Edit / Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><span class="badge bg-primary">{{ $s->nis_nip }}</span></td>
                    <td class="fw-semibold">{{ $s->name }}</td>
                    <td>{{ $s->kelas ?? '-' }}</td>
                    <td>{{ $s->telp ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <!-- Tombol Modal Edit (Unique Index -> {{ $s->id }}) -->
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}" title="Edit Info">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Tombol Delete Akun -->
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa ini? Seluruh data laporan user ini akan ikut terhapus!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Kick / Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- ==============================================
                     MODAL EDIT SISWA (Berada di dalam loop agar terhubung id spesifik)
                     ============================================== -->
                <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 16px;">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Informasi Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.siswa.update', $s->id) }}" method="POST">
                                @csrf @method('PUT') 
                                <div class="modal-body p-4">
                                    <!-- Field NIS (Sebagai Username Login) -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">NIS</label>
                                        <input type="text" class="form-control" name="nis_nip" value="{{ $s->nis_nip }}" required style="border-radius: 10px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Panjang</label>
                                        <input type="text" class="form-control" name="name" value="{{ $s->name }}" required style="border-radius: 10px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Grup / Kelas</label>
                                        <input type="text" class="form-control" name="kelas" value="{{ $s->kelas }}" style="border-radius: 10px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kontak</label>
                                        <input type="text" class="form-control" name="telp" value="{{ $s->telp }}" style="border-radius: 10px;">
                                    </div>
                                    <!-- Jika password tidak dirubah, kirim null value dari views agar form validasi terlewati di controller -->
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Reset / Ganti Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika password tetap" style="border-radius: 10px;">
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Tutup</button>
                                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Simpan Perubahan</button>
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
     MODAL TAMBAH SISWA BARU (Satu Element Modal Default tanpa Index)
     ============================================== -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Daftarkan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- POST ke SiswaController -> Store Method -->
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" class="form-control" name="nis_nip" value="{{ old('nis_nip') }}" required placeholder="Dipergunakan untuk login" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Sesuai nama Akte" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kelas Jurusan</label>
                        <input type="text" class="form-control" name="kelas" value="{{ old('kelas') }}" placeholder="Format: 10 RPL 2" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Detail No. Hp</label>
                        <input type="tel" class="form-control" name="telp" value="{{ old('telp') }}" placeholder="Opsi Tambahan" style="border-radius: 10px;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Sandi Default Baru" style="border-radius: 10px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Tambah Anggota</button>
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
