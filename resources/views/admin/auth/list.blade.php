@extends('admin.layouts.app')
@section('title', 'Daftar Admin')
@section('page-title', 'Daftar Admin Terdaftar')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0 small">Total <strong>{{ $admins->count() }}</strong> admin terdaftar</p>
    </div>
    <a href="{{ route('admin.register') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah Admin
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td class="text-muted small">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:34px;height:34px;background:linear-gradient(135deg,#16a34a,#15803d);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:.8rem;font-weight:800;flex-shrink:0;">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-700" style="font-size:.9rem;font-weight:700;">{{ $admin->name }}</div>
                                @if($admin->email === session('admin_email'))
                                    <span style="font-size:.7rem;background:#f0fdf4;color:#16a34a;padding:2px 8px;border-radius:50px;font-weight:700;">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $admin->email }}</td>
                    <td>
                        <span class="badge-approved">
                            <i class="bi bi-shield-fill-check me-1"></i>{{ ucfirst($admin->role) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $admin->created_at->format('d M Y') }}</td>
                    <td>
                        @if($admin->email !== session('admin_email'))
                            <form action="{{ route('admin.admin-list.destroy', $admin->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus admin {{ $admin->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-people" style="font-size:2.5rem;color:#bbf7d0;"></i>
                        <p class="mt-2 mb-0">Belum ada admin terdaftar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection