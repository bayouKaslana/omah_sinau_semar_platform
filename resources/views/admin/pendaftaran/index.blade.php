@extends('admin.layouts.app')
@section('title', 'Pendaftaran')
@section('page-title', 'Data Pendaftaran')
@section('content')

{{-- Filter & Export Bar --}}
<div class="card shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Filter Lomba</label>
                <select name="lomba_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Lomba --</option>
                    @foreach($lombaList as $l)
                        <option value="{{ $l->id }}" {{ request('lomba_id') == $l->id ? 'selected' : '' }}>
                            {{ Str::limit($l->nama, 50) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Filter Status</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak"  {{ request('status') === 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
            </div>
            <div class="col-md-3 ms-auto text-end">
                <a href="{{ route('admin.pendaftaran.export', ['lomba_id' => request('lomba_id')]) }}"
                   class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i>Export Excel
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">
            Total: <span class="text-primary">{{ $pendaftaran->total() }}</span> pendaftar
        </h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Peserta</th>
                    <th>Lomba</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold">{{ $p->nama_peserta }}</div>
                        <div class="text-muted small">{{ $p->asal_sekolah }}
                            @if($p->kelas) · Kelas {{ $p->kelas }} @endif
                        </div>
                    </td>
                    <td class="small">{{ Str::limit($p->lomba->nama ?? '-', 35) }}</td>
                    <td class="small">
                        <div>{{ $p->email }}</div>
                        <div class="text-muted">{{ $p->no_hp }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $p->status_class }}">{{ $p->status_label }}</span>
                    </td>
                    <td class="small text-muted">{{ $p->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.pendaftaran.show', $p) }}"
                           class="btn btn-sm btn-outline-primary" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('admin.pendaftaran.destroy', $p) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada pendaftaran.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pendaftaran->hasPages())
    <div class="card-footer bg-white">{{ $pendaftaran->links() }}</div>
    @endif
</div>
@endsection
