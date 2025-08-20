<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klinik App - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 8px;
        }
        .sidebar a:hover {
            background: #34495e;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h4>🏥 Klinik App</h4>
            <a href="{{ url('admin/dashboard') }}">Dashboard</a>
            <a href="{{ url('admin/wilayah') }}">Wilayah</a>
            <a href="{{ url('admin/user') }}">User</a>
            <a href="{{ url('admin/pegawai') }}">Pegawai</a>
            <a href="{{ url('admin/tindakan') }}">Tindakan</a>
            <a href="{{ url('admin/obat') }}">Obat</a>
        </div>
        <div class="col-md-10 p-4">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
