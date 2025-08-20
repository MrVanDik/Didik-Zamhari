<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Klinik') }}</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Nunito', sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, #1d4ed8, #3b82f6);
            color: #fff;
            min-height: 100vh;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            padding-top: 70px;
        }
        .sidebar a {
            color: #f9fafb;
            display: block;
            padding: 12px 20px;
            margin: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .content {
            margin-left: 220px;
            padding: 30px;
        }
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Topbar -->
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand font-weight-bold text-primary">
                    🏥 Klinik App
                </span>

                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ url('/home') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="#"><i class="bi bi-geo-alt"></i> Wilayah</a>
            <a href="#"><i class="bi bi-people"></i> User</a>
            <a href="#"><i class="bi bi-person-badge"></i> Pegawai</a>
            <a href="#"><i class="bi bi-clipboard-pulse"></i> Tindakan</a>
            <a href="#"><i class="bi bi-capsule"></i> Obat</a>
        </div>

        <!-- Content -->
        <main class="content pt-5">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
