<!-- Layout / Template Utama Untuk Aplikasi Halaman Siswa -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Siswa') - PRASLY</title>
    <!-- Assets Offline CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/dataTables.bootstrap5.min.css') }}">
    <style>
        /* Gaya dasar Mirip Admin namun beda dominan warna/hue (Biru) */
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #3b82f6;
            --topbar-height: 60px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; min-height: 100vh; }

        /* Sidebar Styling */
        .sidebar {
            position: fixed; left: 0; top: 0; width: var(--sidebar-width);
            height: 100vh; background: var(--sidebar-bg); color: white;
            z-index: 1000; transition: transform 0.3s ease; overflow-y: auto;
        }

        .sidebar-brand { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand i { font-size: 2rem; color: #3b82f6; }
        .sidebar-brand h4 { margin: 8px 0 0; font-weight: 700; font-size: 1.2rem; }
        .sidebar-brand small { opacity: 0.7; font-size: 0.75rem; }

        .sidebar-menu { list-style: none; padding: 15px 0; }
        .sidebar-menu .menu-header {
            padding: 10px 20px 5px; font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 1.5px; color: rgba(255,255,255,0.4); font-weight: 600;
        }
        .sidebar-menu a {
            display: flex; align-items: center; padding: 12px 20px;
            color: rgba(255,255,255,0.7); text-decoration: none;
            transition: all 0.2s ease; font-size: 0.9rem; gap: 12px; border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--sidebar-hover); color: white; border-left-color: var(--sidebar-active);
        }
        .sidebar-menu a i { font-size: 1.1rem; width: 20px; text-align: center; }

        /* Topbar Styling */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height); background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex; align-items: center; justify-content: space-between; padding: 0 25px; z-index: 999;
        }
        .topbar-left { display: flex; align-items: center; gap: 15px; }
        .topbar-left h5 { margin: 0; font-weight: 600; color: #1e293b; }

        .btn-toggle-sidebar {
            display: none; background: none; border: none; font-size: 1.3rem; color: #1e293b; cursor: pointer;
        }

        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .user-info { text-align: right; margin-right: 10px; }
        .user-info .name { font-weight: 600; font-size: 0.9rem; color: #1e293b; }
        .user-info .role { font-size: 0.75rem; color: #64748b; }

        /* Content Container */
        .main-content {
            margin-left: var(--sidebar-width); margin-top: var(--topbar-height);
            padding: 25px; min-height: calc(100vh - var(--topbar-height));
        }

        /* Generic Cards */
        .stat-card {
            border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-card .card-body { padding: 20px; }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; font-size: 1.3rem; color: white;
        }
        .content-card {
            background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 25px; margin-bottom: 20px;
        }

        /* DataTables Custom Forms */
        .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select {
            border-radius: 8px; border: 2px solid #e2e8f0; padding: 6px 12px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .btn-toggle-sidebar { display: block; }
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Sidebar / Navigasi Kiri -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('assets/img/PRASLY LOGO.png') }}" alt="PRASLY" style="max-height: 50px; margin-bottom: 10px;">
            <small class="d-block">Panel Siswa</small>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>
            <li>
                <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="menu-header">Pengaduan</li>
            <li>
                <a href="{{ route('siswa.pengaduan.index') }}" class="{{ request()->routeIs('siswa.pengaduan.index') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i> Pengaduan Saya
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.pengaduan.create') }}" class="{{ request()->routeIs('siswa.pengaduan.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i> Buat Pengaduan
                </a>
            </li>
        </ul>
    </aside>

    <!-- Header Atas -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn-toggle-sidebar" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <h5>@yield('page-title', 'Dashboard')</h5>
        </div>
        <div class="topbar-right">
            <!-- Tampilkan Data Login Siswa -->
            <div class="user-info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">{{ auth()->user()->kelas ?? 'Siswa' }}</div>
            </div>
            
            <!-- Fungsi Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 10px;" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Area Dynamic -->
    <main class="main-content">
        <!-- Render Flash Session Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Assets Scripts -->
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
