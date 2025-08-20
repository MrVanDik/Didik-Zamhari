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
            --primary-color: #2b6777;
            --secondary-color: #52ab98;
            --accent-color: #c8d8e4;
            --text-dark: #2b2b2b;
            --text-light: #6c757d;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Sidebar Styles */
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
            height: 100%;
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
        
        .sidebar-brand i {
            color: var(--accent-color);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            color: white;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .sidebar-menu a.active {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .sidebar-menu i {
            width: 25px;
            text-align: center;
            margin-right: 15px;
            font-size: 1.1rem;
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.3);
            margin: 20px 0;
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Navbar Styles */
        .top-navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .card-body {
            padding: 25px;
        }
        
        /* Stat Card Styles */
        .stat-card {
            text-align: center;
            padding: 25px 20px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
        }
        
        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        /* Table Styles */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .table thead {
            background: var(--primary-color);
            color: white;
        }
        
        .table th {
            font-weight: 500;
            padding: 15px 20px;
            border: none;
        }
        
        .table td {
            padding: 12px 20px;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar-container {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar-container.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .navbar-toggler {
                display: block !important;
            }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-container">
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-hospital me-2"></i>Klinik App
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dokter.index') }}" class="{{ request()->routeIs('dokter.index') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dokter.antrian') }}" class="{{ request()->routeIs('dokter.antrian') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Antrian Pasien
                    </a>
                </li>
                
                
                <li class="sidebar-divider"></li>
                
                <li class="mt-4">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
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
            <h1 class="navbar-title">@yield('title')</h1>
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                    <small class="text-muted">Dokter</small>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
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

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

        <!-- Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar-container').classList.toggle('active');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar-container');
            const navbarToggler = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth <= 992 && 
                !sidebar.contains(event.target) && 
                !navbarToggler.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Auto close sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.querySelector('.sidebar-container').classList.remove('active');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>