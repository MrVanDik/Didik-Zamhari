<!-- resources/views/pendaftaran/dashboard.blade.php -->
@extends('layouts.pendaftaran')

@section('title', 'Dashboard Petugas Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar untuk Aksi Cepat -->
        <!-- Konten Utama -->
        <div class="col-md-9 col-lg-10 ms-sm-auto">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="{{ route('pendaftaran.pasien.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-user-plus fa-sm text-white-50"></i> Pendaftaran Pasien Baru
                </a>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Total Pasien Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Pasien Terdaftar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_pasien, 0) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pasien Baru Hari Ini Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pasien Baru Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pasien_baru_hari_ini }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pendaftaran Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Pendaftaran</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_pendaftaran, 0) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendaftaran Hari Ini Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pendaftaran Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendaftaran_hari_ini }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Antrian Pendaftaran -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-clock mr-2"></i>Status Antrian
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-danger h-100">
                                        <div class="card-body text-center">
                                            <div class="text-lg font-weight-bold text-danger mb-1">Menunggu</div>
                                            <div class="h2 font-weight-bold">{{ $pendaftaran_antri }}</div>
                                            <a href="{{ route('pendaftaran.pendaftaran.index') }}" class="small text-danger">Lihat Daftar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-left-info h-100">
                                        <div class="card-body text-center">
                                            <div class="text-lg font-weight-bold text-info mb-1">Dalam Proses</div>
                                            <div class="h2 font-weight-bold">{{ $pendaftaran_proses }}</div>
                                            <a href="{{ route('pendaftaran.pendaftaran.index') }}" class="small text-info">Lihat Daftar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pendaftaran Terakhir -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-history mr-2"></i>Pendaftaran Terakhir
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No. Reg</th>
                                            <th>Nama Pasien</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftaran_terakhir as $daftar)
                                        <tr>
                                            <td>{{ $daftar->no_reg }}</td>
                                            <td>{{ $daftar->pasien->nama_pasien }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($daftar->status == 'antri') bg-warning 
                                                    @elseif($daftar->status == 'proses') bg-info 
                                                    @else bg-success @endif">
                                                    {{ ucfirst($daftar->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pasien Baru & Quick Actions -->
                <div class="col-lg-6 mb-4">
                    <!-- Pasien Baru Terdaftar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-user-plus mr-2"></i>Pasien Baru Terdaftar
                            </h6>
                            <a href="{{ route('pendaftaran.pasien.index') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-list mr-1"></i> Lihat Semua Pasien
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Tgl. Daftar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pasien_baru as $pasien)
                                        <tr>
                                            <td>{{ $pasien->id_pasien }}</td>
                                            <td>{{ $pasien->nama_pasien }}</td>
                                            <td>{{ $pasien->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('pendaftaran.pasien.show', $pasien->id_pasien) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pendaftaran.pasien.edit', $pasien->id_pasien) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ route('pendaftaran.pasien.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-users mr-1"></i> Lihat Seluruh Data Pasien
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
