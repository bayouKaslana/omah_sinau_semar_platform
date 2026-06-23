@extends('layouts.app')
@section('title', 'Publikasi Peserta - Mitra Prestasi')
@section('content')
<div style="padding-top:80px;min-height:100vh;background:#f8fafc;">
<div class="container py-5">

    {{-- Header --}}
    <div class="text-center mb-5" data-aos="fade-up">
        <span class="section-subtitle">Informasi Resmi</span>
        <h2 class="section-title">Daftar Peserta Olimpiade</h2>
        <p class="text-muted">Cari nama peserta untuk melihat nomor peserta dan informasi lomba</p>
    </div>

    {{-- Search Box --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-6">
            <form method="GET" action="{{ route('publikasi.index') }}">
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text bg-white border-end-0 ps-4">
                        <i class="bi bi-search text-primary"></i>
                    </span>
                    <input
                        type="text"
                        name="cari"
                        class="form-control border-start-0 border-end-0"
                        placeholder="Ketik nama peserta..."
                        value="{{ $keyword }}"
                        autofocus
                        style="border-radius:0;"
                    >
                    <button class="btn btn-primary px-4" type="submit" style="border-radius:0 12px 12px 0;">
                        Cari
                    </button>
                </div>
                <p class="text-muted text-center small mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Ketik sebagian nama juga bisa ditemukan
                </p>
            </form>
        </div>
    </div>

    {{-- Hasil Pencarian --}}
    @if($keyword)
        @if($peserta && $peserta->count() > 0)
            <div class="text-center mb-4">
                <span class="badge bg-primary px-3 py-2 fs-6">
                    {{ $peserta->count() }} peserta ditemukan untuk "{{ $keyword }}"
                </span>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach($peserta as $p)
                <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="border-left: 4px solid #2563eb !important;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <div class="text-muted small mb-1">Nomor Peserta</div>
                                    <div class="fw-bold fs-4 text-primary font-monospace">{{ $p->no_peserta }}</div>
                                </div>
                                <div style="font-size:2.2rem;">{{ $p->mapel_icon }}</div>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $p->nama }}</h5>
                            <p class="text-muted small mb-3">{{ $p->asal_sekolah }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    <i class="bi bi-book me-1"></i>{{ $p->mapel }}
                                </span>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    <i class="bi bi-mortarboard me-1"></i>{{ strtoupper($p->tingkat) }}
                                    @if($p->kelas) Kelas {{ $p->kelas }} @endif
                                </span>
                                @if($p->ruang)
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                    <i class="bi bi-door-open me-1"></i>{{ $p->ruang }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div style="font-size:4rem;">🔍</div>
                <h5 class="mt-3 text-muted">Peserta "{{ $keyword }}" tidak ditemukan</h5>
                <p class="text-muted small">Pastikan penulisan nama sudah benar, atau hubungi panitia</p>
            </div>
        @endif
    @else
        {{-- Placeholder sebelum search --}}
        <div class="text-center py-5" data-aos="fade-up">
            <div style="font-size:5rem;">🏆</div>
            <h5 class="mt-3 text-muted">Masukkan nama peserta untuk mencari</h5>
            <p class="text-muted small">Data peserta akan ditampilkan setelah panitia mempublikasikan</p>
        </div>
    @endif

</div>
</div>
@endsection
