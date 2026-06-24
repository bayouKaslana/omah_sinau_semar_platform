<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Omah Sinau Semar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --primary-light: #f0fdf4;
            --accent: #f59e0b;
            --sidebar-w: 260px;
            --sidebar-bg-top: #052e16;
            --sidebar-bg-bot: #166534;
        }

        * { box-sizing: border-box; }
        body { background: #f1f5f9; font-family: 'Segoe UI', sans-serif; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg-top), var(--sidebar-bg-bot));
            position: fixed; top: 0; left: 0; z-index: 1000;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-logo {
            width: 40px; height: 40px;
            border-radius: 10px; overflow: hidden;
            border: 2px solid rgba(255,255,255,.2);
            flex-shrink: 0;
        }
        .sidebar-logo img { width: 100%; height: 100%; object-fit: cover; }
        .sidebar-logo-fallback {
            width: 100%; height: 100%;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 1.2rem;
        }
        .sidebar-brand-text h5 { color: #fff; margin: 0; font-weight: 800; font-size: 0.95rem; line-height: 1.2; }
        .sidebar-brand-text small { color: rgba(255,255,255,.55); font-size: 0.72rem; }

        .sidebar nav { flex: 1; padding: 8px 0; overflow-y: auto; }
        .sidebar .nav-link {
            color: rgba(255,255,255,.72);
            padding: .65rem 1.5rem;
            border-radius: 10px;
            margin: .1rem .75rem;
            transition: all .2s;
            font-size: 0.88rem;
            font-weight: 600;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; flex-shrink: 0; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.12); }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.18);
            border-left: 3px solid var(--accent);
            padding-left: calc(1.5rem - 3px);
        }
        .sidebar-section {
            padding: .75rem 1.5rem .25rem;
            color: rgba(255,255,255,.35);
            font-size: .68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .1em;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.1);
        }
        .sidebar-footer a {
            color: rgba(255,255,255,.55);
            font-size: 0.8rem; text-decoration: none;
            display: flex; align-items: center; gap: 6px;
            transition: color .2s;
        }
        .sidebar-footer a:hover { color: #fff; }

        /* MAIN */
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; }

        /* TOPBAR */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .875rem 1.5rem;
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-size: 1rem; font-weight: 800; color: #1e293b; margin: 0; }
        .topbar-date {
            font-size: 0.8rem; color: #64748b;
            display: flex; align-items: center; gap: 5px;
        }

        /* Admin avatar */
        .admin-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .85rem; font-weight: 800;
            flex-shrink: 0;
        }
        .dropdown-toggle::after { display: none; }
        .dropdown-menu {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
            padding: 8px !important;
            min-width: 200px;
        }
        .dropdown-item {
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 8px 12px;
        }
        .dropdown-item:hover { background: var(--primary-light); color: var(--primary); }
        .dropdown-item.text-danger:hover { background: #fef2f2; color: #dc2626 !important; }

        /* CONTENT */
        .content-area { padding: 1.5rem; }

        /* CARDS */
        .stat-card {
            background: #fff; border-radius: 14px;
            padding: 1.4rem; border: 1.5px solid #e2e8f0;
            transition: all .2s;
        }
        .stat-card:hover { border-color: var(--primary); box-shadow: 0 4px 20px rgba(22,163,74,.1); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-icon.green  { background: #dcfce7; color: var(--primary); }
        .stat-icon.gold   { background: #fef3c7; color: var(--accent); }
        .stat-icon.blue   { background: #dbeafe; color: #2563eb; }
        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }

        .card { border-radius: 14px; border: 1.5px solid #e2e8f0 !important; }
        .card-header {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-radius: 14px 14px 0 0 !important;
            padding: 1rem 1.25rem !important;
            font-weight: 800 !important;
        }

        /* TABLE */
        .table th {
            font-size: .75rem; font-weight: 800;
            text-transform: uppercase; color: #64748b;
            background: #f8fafc; border-bottom: 2px solid #e2e8f0;
            padding: 12px 16px;
        }
        .table td { padding: 12px 16px; vertical-align: middle; font-size: 0.88rem; }
        .table tbody tr:hover { background: #f8fafc; }

        /* BADGES */
        .badge-open   { background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; }
        .badge-closed { background: #fee2e2; color: #dc2626; padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; }
        .badge-coming { background: #fef9c3; color: #a16207; padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; }
        .badge-pending  { background: #fef3c7; color: #d97706; padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; }
        .badge-approved { background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; }

        /* BUTTONS */
        .btn-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
        }
        .btn-primary:hover {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }
        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
        }
        .btn-outline-primary:hover {
            background: var(--primary) !important;
            color: #fff !important;
        }
        .btn-success {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
        }

        /* FORM */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(22,163,74,.12) !important;
        }
        .form-label { font-weight: 700; font-size: .85rem; color: #374151; }

        /* ALERT */
        .alert-success {
            background: #f0fdf4; color: #15803d;
            border: 1.5px solid #bbf7d0; border-radius: 10px;
        }
        .alert-danger {
            background: #fef2f2; color: #dc2626;
            border: 1.5px solid #fecaca; border-radius: 10px;
        }

        /* PAGINATION */
        .page-link { color: var(--primary) !important; border-radius: 8px !important; font-weight: 600; }
        .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <img src="{{ asset('image/Logo(new).jpeg') }}" alt="Logo"
                 onerror="this.parentElement.innerHTML='<div class=\'sidebar-logo-fallback\'><i class=\'bi bi-trophy-fill\'></i></div>'">
        </div>
        <div class="sidebar-brand-text">
            <h5>Omah Sinau Semar</h5>
            <small>Panel Admin</small>
        </div>
    </div>

    <nav>
        <div class="sidebar-section">Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Konten</div>
        <a href="{{ route('admin.lomba.index') }}"
           class="nav-link {{ request()->routeIs('admin.lomba*') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Lomba
        </a>
        <a href="{{ route('admin.pendaftaran.index') }}"
           class="nav-link {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Pendaftaran
        </a>
        <a href="{{ route('admin.peserta.index') }}"
           class="nav-link {{ request()->routeIs('admin.peserta*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Peserta
        </a>
        <a href="{{ route('admin.blog.index') }}"
           class="nav-link {{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
            <i class="bi bi-journal-richtext"></i> Blog
        </a>
        <a href="{{ route('admin.galeri.index') }}"
           class="nav-link {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Galeri
        </a>

        <div class="sidebar-section">Lainnya</div>
        <a href="{{ route('admin.register') }}" 
           class="nav-link {{ request()->routeIs('admin.register') ? 'active' : '' }}">
           <i class="bi bi-person-plus-fill"></i> Tambah Admin
        </a>
        <a href="{{ url('/') }}" class="nav-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none;border:none;padding:0;width:100%;text-align:left;">
                <a href="#" onclick="this.closest('form').submit();return false;"
                   style="color:rgba(255,255,255,.5);font-size:0.8rem;text-decoration:none;display:flex;align-items:center;gap:6px;transition:color .2s;"
                   onmouseover="this.style.color='#fca5a5'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar">
        <h6 class="topbar-title">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="topbar-date d-none d-md-flex">
                <i class="bi bi-calendar3"></i>{{ now()->format('d M Y') }}
            </span>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2 rounded-3"
                        data-bs-toggle="dropdown">
                    <div class="admin-avatar">
                        {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline" style="font-size:.85rem;font-weight:600;">
                        {{ session('admin_name', 'Admin') }}
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text" style="font-size:.8rem;color:#64748b;padding:8px 12px;">
                            {{ session('admin_email', '') }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>