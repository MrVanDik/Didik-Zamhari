<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Klinik App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4e73df;
            --secondary-color: #6f42c1;
            --accent-color: #e83e8c;
        }

        body {
            background-color: #f8f9fc;
        }

        .sidebar-container {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            position: fixed;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar {
            padding: 20px 15px;
        }

        .sidebar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 30px;
            padding: 15px;
            border-bottom: 2px solid rgba(255,255,255,0.3);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu a {
            color: white;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            background: white;
            color: var(--primary-color);
            font-weight: 500;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-container">
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-cash-register me-2"></i>Klinik App
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('kasir.dashboard') }}" class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.tagihan') }}" class="{{ request()->routeIs('kasir.tagihan') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Tagihan Pasien
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.riwayat') }}" class="{{ request()->routeIs('kasir.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Riwayat Pembayaran
                    </a>
                </li>
                <li class="mt-4">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <button class="navbar-toggler d-lg-none border-0 bg-transparent" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars fs-4 text-primary"></i>
            </button>
            <h1 class="navbar-title mb-0">@yield('title')</h1>
            <div class="user-info">
                <div class="user-avatar bg-primary text-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <small class="text-muted">Kasir</small>
                </div>
            </div>
        </nav>

        <!-- Notification -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar-container').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html>
