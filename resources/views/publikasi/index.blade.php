@extends('layouts.app')
@section('title', 'Publikasi Peserta - Omah Sinau Semar')

@push('styles')
<style>
.publikasi-page {
    padding-top: 80px;
    min-height: 100vh;
    background: #f8fafc;
    transition: background 0.3s;
}
.publikasi-header {
    background: linear-gradient(135deg, #f0fdf4 0%, #fefce8 100%);
    padding: 60px 0 40px;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}
.search-box {
    background: #ffffff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(22,163,74,0.10);
    border: 1.5px solid #bbf7d0;
    max-width: 600px;
    margin: 0 auto;
}
.search-input-wrap {
    display: flex;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.search-input-wrap:focus-within { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,0.12); }
.search-icon {
    padding: 0 16px;
    background: #f8fafc;
    display: flex; align-items: center;
    color: #16a34a; font-size: 1.1rem;
    border-right: 1px solid #e2e8f0;
}
.search-input {
    flex: 1; border: none; outline: none;
    padding: 14px 16px; font-size: 0.97rem;
    color: #1e293b; background: transparent;
}
.search-input::placeholder { color: #94a3b8; }
.search-btn {
    background: #16a34a; color: white; border: none;
    padding: 14px 24px; font-weight: 700; font-size: 0.92rem;
    cursor: pointer; transition: background 0.2s;
    white-space: nowrap;
}
.search-btn:hover { background: #15803d; }

.result-count {
    display: inline-flex; align-items: center; gap: 8px;
    background: #f0fdf4; color: #15803d;
    border: 1.5px solid #bbf7d0;
    padding: 8px 20px; border-radius: 50px;
    font-size: 0.88rem; font-weight: 700;
    margin-bottom: 28px;
}

.peserta-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1.5px solid #e2e8f0;
    border-left: 4px solid #16a34a !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    padding: 24px;
    height: 100%;
    transition: all 0.2s;
}
.peserta-card:hover { box-shadow: 0 6px 24px rgba(22,163,74,0.15); border-color: #16a34a; }
.peserta-no-label { font-size: 0.72rem; color: #64748b; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; }
.peserta-no { font-size: 1.8rem; font-weight: 900; color: #16a34a; font-family: monospace; line-height: 1; }
.peserta-icon { font-size: 2.2rem; }
.peserta-nama { font-size: 1rem; font-weight: 800; color: #1e293b; margin: 12px 0 4px; }
.peserta-sekolah { font-size: 0.82rem; color: #64748b; margin-bottom: 14px; }
.peserta-badges { display: flex; flex-wrap: wrap; gap: 8px; }
.badge-mapel  { background: #f0fdf4; color: #15803d; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
.badge-tingkat { background: #fef3c7; color: #a16207; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
.badge-ruang  { background: #ede9fe; color: #6d28d9; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-state .empty-icon { font-size: 5rem; margin-bottom: 16px; }
.empty-state h5 { color: #475569; font-weight: 700; margin-bottom: 8px; }
.empty-state p { color: #94a3b8; font-size: 0.88rem; }

/* DARK MODE */
[data-theme="dark"] .publikasi-page { background: #0f172a; }
[data-theme="dark"] .publikasi-header { background: linear-gradient(135deg, #0f172a, #1e293b); border-color: #334155; }
[data-theme="dark"] .search-box { background: #1e293b; border-color: #334155; }
[data-theme="dark"] .search-input-wrap { border-color: #334155; }
[data-theme="dark"] .search-input-wrap:focus-within { border-color: #16a34a; }
[data-theme="dark"] .search-icon { background: #0f172a; border-color: #334155; }
[data-theme="dark"] .search-input { color: #f1f5f9; background: #1e293b; }
[data-theme="dark"] .search-input::placeholder { color: #475569; }
[data-theme="dark"] .peserta-card { background: #1e293b; border-color: #334155; }
[data-theme="dark"] .peserta-nama { color: #f1f5f9; }
[data-theme="dark"] .peserta-sekolah { color: #94a3b8; }
[data-theme="dark"] .peserta-no-label { color: #64748b; }
[data-theme="dark"] .empty-state h5 { color: #94a3b8; }
[data-theme="dark"] .section-title { color: #f1f5f9; }
[data-theme="dark"] .text-muted { color: #64748b !important; }
</style>
@endpush

@section('content')
<div class="publikasi-page">
    <div class="publikasi-header">
        <span class="section-subtitle">Informasi Resmi</span>
        <h2 class="section-title">Daftar Peserta Olimpiade</h2>
        <p class="text-muted">Cari nama peserta untuk melihat nomor peserta dan informasi lomba</p>
    </div>

    <div class="container py-5">
        {{-- Search Box --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7">
                <div class="search-box">
                    <form method="GET" action="{{ route('publikasi.index') }}">
                        <div class="search-input-wrap">
                            <div class="search-icon"><i class="bi bi-search"></i></div>
                            <input type="text" name="cari" class="search-input"
                                   placeholder="Ketik nama peserta..."
                                   value="{{ $keyword }}" autofocus>
                            <button type="submit" class="search-btn">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                        </div>
                        <p class="text-muted text-center small mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Ketik sebagian nama juga bisa ditemukan
                        </p>
                    </form>
                </div>
            </div>
        </div>

        {{-- Hasil --}}
        @if($keyword)
            @if($hasil && $hasil->count() > 0)
                <div class="text-center mb-4">
                    <span class="result-count">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ $hasil->count() }} peserta ditemukan untuk "{{ $keyword }}"
                    </span>
                </div>
                <div class="row g-3 justify-content-center">
                    @foreach($hasil as $p)
                    <div class="col-lg-5 col-md-6">
                        <div class="peserta-card">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div>
                                    <div class="peserta-no-label">Nomor Peserta</div>
                                    <div class="peserta-no">{{ $p['no_peserta'] ?? '-' }}</div>
                                </div>
                                <div class="peserta-icon">{{ $p['mapel_icon'] ?? '🏆' }}</div>
                            </div>
                            <div class="peserta-nama">{{ $p['nama'] }}</div>
                            <div class="peserta-sekolah">
                                <i class="bi bi-building me-1"></i>{{ $p['asal_sekolah'] ?? '-' }}
                            </div>
                            <div class="peserta-badges">
                                <span class="badge-mapel">
                                    <i class="bi bi-book me-1"></i>{{ $p['mapel'] ?? $p['nama_lomba'] ?? '-' }}
                                </span>
                                <span class="badge-tingkat">
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $p['tingkat'] ?? '' }}
                                    @if(!empty($p['kelas'])) Kelas {{ $p['kelas'] }} @endif
                                </span>
                                @if(!empty($p['ruang']))
                                <span class="badge-ruang">
                                    <i class="bi bi-door-open me-1"></i>{{ $p['ruang'] }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🔍</div>
                    <h5>Peserta "{{ $keyword }}" tidak ditemukan</h5>
                    <p>Pastikan penulisan nama sudah benar, atau hubungi panitia</p>
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">🏆</div>
                <h5>Masukkan nama peserta untuk mencari</h5>
                <p>Data peserta akan ditampilkan setelah panitia mempublikasikan</p>
            </div>
        @endif
    </div>
</div>
@endsection