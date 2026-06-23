@extends('admin.layouts.app')
@section('title', 'Import Peserta')
@section('page-title', 'Import Peserta dari Excel')
@section('content')
<div class="row g-4" style="max-width:700px;">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i>Upload File Excel</h6>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.peserta.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih File Excel (.xlsx / .xls)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                        <small class="text-muted">Maksimal 5MB. Format sesuai contoh nomor peserta yang sudah ada.</small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Import Sekarang
                    </button>
                    <a href="{{ route('admin.peserta.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Panduan --}}
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Format File Excel</h6>
                <p class="small text-muted mb-2">Sistem akan otomatis membaca kolom-kolom berikut dari file Excel kamu:</p>
                <table class="table table-sm table-bordered mb-3">
                    <thead class="table-primary">
                        <tr><th>Kolom</th><th>Keterangan</th><th>Contoh</th></tr>
                    </thead>
                    <tbody class="small">
                        <tr><td><code>NO PESERTA</code></td><td>Nomor peserta</td><td>MA 1001</td></tr>
                        <tr><td><code>NAMA</code></td><td>Nama lengkap peserta</td><td>VINCE AUSTIN</td></tr>
                        <tr><td><code>ASAL SEKOLAH</code></td><td>Nama sekolah</td><td>SDN 1 SILIRAGUNG</td></tr>
                        <tr><td><code>MAPEL</code></td><td>Mata pelajaran</td><td>MATEMATIKA</td></tr>
                        <tr><td><code>LV</code></td><td>Tingkat/Level</td><td>TK / 1 / 7</td></tr>
                    </tbody>
                </table>
                <div class="alert alert-info small mb-0">
                    <i class="bi bi-lightbulb-fill me-2"></i>
                    File Excel yang pernah dipakai sebelumnya (format NOMOR_PESERTA.xlsx) bisa langsung diimport tanpa perlu diubah!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
