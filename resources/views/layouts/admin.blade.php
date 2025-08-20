<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Klinik App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --text-light: #ecf0f1;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        /* Header Styles */
        .top-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
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
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .current-time {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 1rem;
            box-shadow: 3px 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-brand {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1.5rem;
        }
        
        .sidebar-brand h3 {
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-nav {
            padding: 0 1rem;
        }
        
        .nav-link {
            color: #dbe8f5;
            font-weight: 500;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 25px;
        }
        
        .nav-link:hover, 
        .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(5px);
        }
        
        .nav-link.logout {
            color: #e74c3c;
            margin-top: 2rem;
        }
        
        .nav-link.logout:hover {
            background: rgba(231, 76, 60, 0.2);
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
            margin-top: 60px; /* Space for fixed header */
        }
        
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        /* Card Styles */
        .stat-card {
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        
        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }
        
        /* Activity Item */
        .activity-item {
            border-left: 3px solid var(--accent-color);
            padding-left: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .activity-item::before {
            content: '';
            width: 12px;
            height: 12px;
            background: var(--accent-color);
            border-radius: 50%;
            position: absolute;
            left: -7.5px;
            top: 5px;
        }
        
        /* Mobile Toggle Button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .top-header {
                left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
        }
        
        /* Dropdown Menu */
        .user-dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
            min-width: 200px;
            display: none;
            z-index: 1000;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
        }
        
        .dropdown-divider {
            border-top: 1px solid #eee;
            margin: 0.25rem 0;
        }
        
        .user-dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3><i class="bi bi-hospital"></i> <span>Klinik App</span></h3>
        </div>
        
        <nav class="sidebar-nav">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->is('admin/wilayah*') ? 'active' : '' }}" href="{{ route('admin.wilayah.index') }}">
                <i class="bi bi-geo-alt"></i> <span>Wilayah</span>
            </a>
            <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                <i class="bi bi-people"></i> <span>User</span>
            </a>
            <a class="nav-link {{ request()->is('admin/pegawai*') ? 'active' : '' }}" href="{{ route('admin.pegawai.index') }}">
                <i class="bi bi-person-badge"></i> <span>Pegawai</span>
            </a>
            <a class="nav-link {{ request()->is('admin/tindakan*') ? 'active' : '' }}" href="{{ route('admin.tindakan.index') }}">
                <i class="bi bi-clipboard2-pulse"></i> <span>Tindakan</span>
            </a>
            <a class="nav-link {{ request()->is('admin/obat*') ? 'active' : '' }}" href="{{ route('admin.obat.index') }}">
                <i class="bi bi-capsule"></i> <span>Obat</span>
            </a>
            
           
            <a class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> <span>Laporan</span>
            </a>
            
        </nav>
    </div>

    <header class="top-header">
        <div class="current-time">
            <i class="bi bi-clock"></i>
            <span id="current-time-display">{{ date('d M Y, H:i:s') }}</span>
        </div>
        
        <div class="user-dropdown">
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">
                        @if(Auth::user()->id_role == '1')
                            Administrator
                        @elseif(Auth::user()->id_role == '3')
                            Dokter
                        @elseif(Auth::user()->id_role == '2')
                            Petugas
                        @elseif(Auth::user()->id_role == '4')
                            Kasir
                        @else
                            Staff
                        @endif
                    </div>
                </div>
                <i class="bi bi-chevron-down"></i>
            </div>
            
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">
                    <i class="bi bi-person"></i> Profil Saya
                </a>
                <a href="#" class="dropdown-item">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Mobile Toggle Button -->
    <button class="btn btn-primary sidebar-toggle">
        <i class="bi bi-list"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992 && 
                    !sidebar.contains(event.target) && 
                    !sidebarToggle.contains(event.target) &&
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });
            
            // Update waktu secara real-time
            function updateTime() {
                const now = new Date();
                const options = { 
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric',
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                };
                document.getElementById('current-time-display').textContent = now.toLocaleDateString('id-ID', options);
            }
            
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>