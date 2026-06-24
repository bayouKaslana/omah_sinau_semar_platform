@extends('admin.layouts.app')
@section('title', isset($peserta) ? 'Edit Peserta' : 'Tambah Peserta')
@section('page-title', isset($peserta) ? 'Edit Peserta' : 'Tambah Peserta')
@section('content')
<div class="card shadow-sm" style="max-width:600px;">
    <div class="card-body p-4">
       <form action="{{ isset($peserta) ? route('admin.peserta.update', ['peserta' => $peserta->id]) : route('admin.peserta.store') }}" method="POST">
            @csrf
            @if(isset($peserta)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Nomor Peserta *</label>
                    <input type="text" name="no_peserta" class="form-control font-monospace fw-bold @error('no_peserta') is-invalid @enderror"
                        value="{{ old('no_peserta', $peserta->no_peserta ?? '') }}"
                        placeholder="Contoh: MA 1001" required>
                    @error('no_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7">
                    <label class="form-label fw-semibold">Nama Peserta *</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $peserta->nama ?? '') }}"
                        placeholder="Nama lengkap" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Asal Sekolah *</label>
                    <input type="text" name="asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror"
                        value="{{ old('asal_sekolah', $peserta->asal_sekolah ?? '') }}"
                        placeholder="Nama sekolah" required>
                    @error('asal_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mata Pelajaran *</label>
                    <select name="mapel" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['Matematika','Bahasa Inggris','Sains','IPS','Mewarnai'] as $m)
                            <option value="{{ $m }}" {{ old('mapel', $peserta->mapel ?? '') === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tingkat *</label>
                    <select name="tingkat" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['TK','SD','SMP'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat', $peserta->tingkat ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kelas</label>
                    <input type="text" name="kelas" class="form-control"
                        value="{{ old('kelas', $peserta->kelas ?? '') }}"
                        placeholder="1, 2, ...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Level</label>
                    <input type="text" name="ruang" class="form-control"
                        value="{{ old('ruang', $peserta->ruang ?? '') }}"
                        placeholder="Contoh: Level 1">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.peserta.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection