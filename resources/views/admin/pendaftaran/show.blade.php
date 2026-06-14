@extends('admin.layouts.app')
@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Pendaftaran')
@section('content')
<div class="row g-4" style="max-width:750px;">

    {{-- Info Peserta --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2 text-primary"></i>Info Peserta</h6>
                <span class="badge bg-{{ $pendaftaran->status_class }} fs-6">{{ $pendaftaran->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="small text-muted">Nama Peserta</div>
                        <div class="fw-semibold">{{ $pendaftaran->nama_peserta }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Asal Sekolah</div>
                        <div class="fw-semibold">{{ $pendaftaran->asal_sekolah }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Kelas</div>
                        <div class="fw-semibold">{{ $pendaftaran->kelas ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Guru Pembimbing</div>
                        <div class="fw-semibold">{{ $pendaftaran->nama_guru_pembimbing ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Email</div>
                        <div class="fw-semibold">{{ $pendaftaran->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">No HP</div>
                        <div class="fw-semibold">{{ $pendaftaran->no_hp }}</div>
                    </div>
                    <div class="col-12">
                        <div class="small text-muted">Lomba yang Diikuti</div>
                        <div class="fw-semibold">{{ $pendaftaran->lomba->nama ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="small text-muted">Tanggal Daftar</div>
                        <div class="fw-semibold">{{ $pendaftaran->created_at->format('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hubungi via WA --}}
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background:linear-gradient(135deg,#25d366,#128c7e);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="text-white">
                        <h6 class="fw-bold mb-1"><i class="bi bi-whatsapp me-2"></i>Hubungi Peserta via WhatsApp</h6>
                        <p class="mb-0 small opacity-75">Klik tombol untuk langsung chat ke nomor peserta dengan pesan otomatis</p>
                    </div>
                    <a href="{{ $waLink }}" target="_blank" class="btn btn-light fw-bold px-4">
                        <i class="bi bi-whatsapp me-2 text-success"></i>Buka WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Status --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-arrow-repeat me-2 text-primary"></i>Update Status Pendaftaran
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.status', $pendaftaran) }}" method="POST"
                      class="d-flex gap-2 align-items-center">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select" style="max-width:200px;">
                        <option value="menunggu" {{ $pendaftaran->status === 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="diterima" {{ $pendaftaran->status === 'diterima' ? 'selected' : '' }}>✅ Diterima</option>
                        <option value="ditolak"  {{ $pendaftaran->status === 'ditolak'  ? 'selected' : '' }}>❌ Ditolak</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <p class="text-muted small mt-2 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Setelah update status, gunakan tombol WhatsApp di atas untuk memberi tahu peserta.
                </p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
