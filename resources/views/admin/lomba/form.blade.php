@extends('admin.layouts.app')
@section('title', isset($lomba) ? 'Edit Lomba' : 'Tambah Lomba')
@section('page-title', isset($lomba) ? 'Edit Lomba' : 'Tambah Lomba')
@section('content')
<div class="card shadow-sm" style="max-width:800px;">
    <div class="card-body p-4">
        <form action="{{ isset($lomba) ? route('admin.lomba.update', $lomba) : route('admin.lomba.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($lomba)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Lomba *</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $lomba->nama ?? '') }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Penyelenggara *</label>
                    <input type="text" name="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror" value="{{ old('penyelenggara', $lomba->penyelenggara ?? '') }}" required>
                    @error('penyelenggara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['bahasa-inggris','matematika','sains','ips','mewarnai'] as $k)
                            <option value="{{ $k }}" {{ old('kategori', $lomba->kategori ?? '') === $k ? 'selected' : '' }}>{{ ucwords(str_replace('-', ' ', $k)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tingkat</label>
                    <select name="tingkat" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['tk','LEVEL 1','LEVEL 2','LEVEL 3','LEVEL 4'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat', $lomba->tingkat ?? '') === $t ? 'selected' : '' }}>{{ strtoupper($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['open' => 'Terbuka', 'coming' => 'Segera', 'closed' => 'Ditutup'] as $v => $l)
                            <option value="{{ $v }}" {{ old('status', $lomba->status ?? '') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', isset($lomba) ? $lomba->tanggal_mulai?->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', isset($lomba) ? $lomba->tanggal_selesai?->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $lomba->lokasi ?? '') }}" placeholder="Online / Nama Kota">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hadiah</label>
                    <input type="text" name="hadiah" class="form-control" value="{{ old('hadiah', $lomba->hadiah ?? '') }}" placeholder="Contoh: Rp 5.000.000">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Link Pendaftaran</label>
                    <input type="url" name="link_daftar" class="form-control" value="{{ old('link_daftar', $lomba->link_daftar ?? '') }}" placeholder="https://...">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $lomba->deskripsi ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Poster / Gambar</label>
                    <input type="file" name="poster" class="form-control" accept="image/*">
                    @if(isset($lomba) && $lomba->poster)
                        <img src="{{ $lomba->poster_url }}" class="mt-2 rounded" style="height:80px;object-fit:cover;">
                    @endif
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured" {{ old('is_featured', $lomba->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="featured">Tampilkan sebagai Featured</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.lomba.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection