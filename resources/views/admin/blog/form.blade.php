
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    #editorToolbar {
        border: 1.5px solid #e2e8f0;
        border-bottom: none;
        border-radius: 12px 12px 0 0;
        background: #f8fafc;
        padding: .5rem;
    }
    #editorBody {
        border: 1.5px solid #e2e8f0;
        border-radius: 0 0 12px 12px;
        background: #fff;
        font-family: 'Segoe UI', sans-serif;
    }
    #editorBody:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,.1);
    }
    .ql-toolbar.ql-snow { border: none !important; }
    .ql-container.ql-snow { border: none !important; font-size: 1rem; }
    .ql-editor { min-height: 300px; padding: 1.2rem 1.5rem; }
    .ql-editor p { margin-bottom: .75rem; line-height: 1.8; }
</style>
@endpush
@extends('admin.layouts.app')
@section('title', isset($blog) ? 'Edit Artikel' : 'Tambah Artikel')
@section('page-title', isset($blog) ? 'Edit Artikel' : 'Tambah Artikel')
@section('content')
<div class="card shadow-sm" style="max-width:900px;">
    <div class="card-body p-4">
        <form action="{{ isset($blog) ? route('admin.blog.update', $blog) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($blog)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Judul Artikel *</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $blog->judul ?? '') }}" placeholder="Masukkan judul artikel" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kategori</label>
                    <input type="text" name="kategori" class="form-control"
                        value="{{ old('kategori', $blog->kategori ?? '') }}" placeholder="Tips & Trik, Panduan, dll">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                        value="{{ old('penulis', $blog->penulis ?? 'Admin Mitra Prestasi') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @if(isset($blog) && $blog->thumbnail)
                        <img src="{{ $blog->thumbnail_url }}" class="mt-2 rounded" style="height:60px;object-fit:cover;">
                    @endif
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Isi Artikel *</label>

                    {{-- Hidden input yang dikirim ke server --}}
                    <input type="hidden" name="isi" id="isiInput">

                    @error('isi')
                        <div class="text-danger small mb-1">{{ $message }}</div>
                    @enderror

                    {{-- Editor toolbar --}}
                    <div id="editorToolbar">
                        <span class="ql-formats">
                            <select class="ql-header">
                                <option selected></option>
                                <option value="1">Judul Besar</option>
                                <option value="2">Judul Sedang</option>
                                <option value="3">Judul Kecil</option>
                            </select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-bold" title="Tebal"></button>
                            <button class="ql-italic" title="Miring"></button>
                            <button class="ql-underline" title="Garis Bawah"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered" title="Daftar Bernomor"></button>
                            <button class="ql-list" value="bullet" title="Daftar Poin"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link" title="Link"></button>
                            <button class="ql-blockquote" title="Kutipan"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-clean" title="Hapus Format"></button>
                        </span>
                    </div>
                    <div id="editorBody" style="min-height:320px;font-size:1rem;"></div>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Tulis artikel seperti biasa — gunakan toolbar di atas untuk format teks
                    </small>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="hidden" name="is_featured" value="0">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured"
                            {{ old('is_featured', $blog->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="featured">
                            <i class="bi bi-star-fill text-warning me-1"></i>Jadikan Featured Post
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
const quill = new Quill('#editorBody', {
    theme: 'snow',
    modules: { toolbar: '#editorToolbar' },
    placeholder: 'Tulis isi artikel di sini...',
});

// Load existing content saat edit
const existing = {!! json_encode(old('isi', $blog->isi ?? '')) !!};
if (existing) {
    quill.root.innerHTML = existing;
}

// Sync ke hidden input sebelum form submit
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('isiInput').value = quill.root.innerHTML;
});

// Validasi tidak boleh kosong
document.querySelector('form').addEventListener('submit', function(e) {
    const val = quill.root.innerHTML.replace(/<[^>]*>/g, '').trim();
    if (!val) {
        e.preventDefault();
        quill.root.style.border = '1.5px solid #ef4444';
        quill.root.focus();
        alert('Isi artikel tidak boleh kosong!');
    }
});
</script>
@endpush
