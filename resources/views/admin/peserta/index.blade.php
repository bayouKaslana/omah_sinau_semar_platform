@extends('admin.layouts.app')
@section('title', 'Kelola Peserta')
@section('page-title', 'Kelola Peserta & Publikasi')
@section('content')

{{-- Status & Action Bar --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card text-center">
            <div class="fs-2 fw-bold text-primary">{{ $total }}</div>
            <div class="text-muted small">Total Peserta</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card text-center">
            <div class="fs-2 fw-bold text-success">{{ $published }}</div>
            <div class="text-muted small">Sudah Dipublikasi</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card text-center">
            <div class="fs-2 fw-bold text-warning">{{ $total - $published }}</div>
            <div class="text-muted small">Belum Dipublikasi</div>
        </div>
    </div>
</div>

{{-- Publish Controls --}}
<div class="card shadow-sm mb-4" style="background:linear-gradient(135deg,#1e3a5f,#2563eb);border:none;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="text-white">
                <h6 class="fw-bold mb-1"><i class="bi bi-eye-fill me-2"></i>Kontrol Publikasi</h6>
                <p class="mb-0 small opacity-75">Orang tua hanya bisa melihat data yang sudah dipublikasikan</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.peserta.publish-all') }}" method="POST" onsubmit="return confirm('Publikasikan SEMUA peserta?')">
                    @csrf
                    <button class="btn btn-success fw-bold">
                        <i class="bi bi-eye-fill me-2"></i>Publikasikan Semua
                    </button>
                </form>
                <form action="{{ route('admin.peserta.unpublish-all') }}" method="POST" onsubmit="return confirm('Sembunyikan semua publikasi?')">
                    @csrf
                    <button class="btn btn-warning fw-bold">
                        <i class="bi bi-eye-slash-fill me-2"></i>Sembunyikan Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Action Buttons --}}
<div class="d-flex gap-2 justify-content-between mb-3 flex-wrap">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.peserta.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Manual
        </a>
        <a href="{{ route('admin.peserta.import.form') }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel me-2"></i>Import Excel
        </a>
    </div>
    <a href="{{ route('publikasi.index') }}" target="_blank" class="btn btn-outline-primary">
        <i class="bi bi-box-arrow-up-right me-2"></i>Lihat Halaman Publik
    </a>
</div>

{{-- Tabel --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No Peserta</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Mapel</th>
                    <th>Tingkat</th>
                    <th>Ruang</th>
                    <th>Publik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta as $p)
                <tr>
                    <td><span class="font-monospace fw-bold text-primary">{{ $p->no_peserta }}</span></td>
                    <td class="fw-semibold">{{ $p->nama }}</td>
                    <td class="small text-muted">{{ $p->asal_sekolah }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $p->mapel }}</span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ strtoupper($p->tingkat) }}</span></td>
                    <td class="small">{{ $p->ruang ?? '-' }}</td>
                    <td>
                        @if($p->is_published)
                            <span class="badge bg-success"><i class="bi bi-eye-fill me-1"></i>Publik</span>
                        @else
                            <span class="badge bg-secondary"><i class="bi bi-eye-slash-fill me-1"></i>Tersembunyi</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.peserta.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.peserta.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus peserta ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-people" style="font-size:2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada peserta. Tambah manual atau import Excel.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($peserta->hasPages())
    <div class="card-footer bg-white">{{ $peserta->links() }}</div>
    @endif
</div>
@endsection
