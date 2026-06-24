@extends('admin.layouts.app')
@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin Baru')
@section('content')

<div class="card shadow-sm" style="max-width:560px;">
    <div class="card-header">
        <i class="bi bi-person-plus-fill me-2" style="color:#16a34a;"></i>
        Formulir Pendaftaran Admin Baru
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.register.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Nama lengkap admin" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="email@domain.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password *</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('passwordInput', 'iconPw')">
                        <i class="bi bi-eye-fill" id="iconPw"></i>
                    </button>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Password *</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="passwordConfirm"
                           class="form-control" placeholder="Ulangi password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('passwordConfirm', 'iconPwC')">
                        <i class="bi bi-eye-fill" id="iconPwC"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1.5px solid #bbf7d0;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-fill-check" style="color:#16a34a;font-size:1.2rem;"></i>
                    <div>
                        <div style="font-weight:700;font-size:.88rem;color:#15803d;">Role: Admin</div>
                        <div style="font-size:.78rem;color:#64748b;">Akses penuh ke seluruh panel admin</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-check-fill me-2"></i>Daftarkan Admin
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash-fill';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-fill';
    }
}
</script>
@endsection