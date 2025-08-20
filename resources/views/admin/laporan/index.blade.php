@php
use Carbon\Carbon;
@endphp

@extends('layouts.admin')

@section('title', 'Laporan - Klinik App')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="bi bi-file-earmark-bar-graph"></i> Laporan Klinik</h2>
        <p class="text-muted">Analisis data dan statistik klinik</p>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold"><i class="bi bi-funnel"></i> Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="start_date" 
                           value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="end_date" 
                           value="{{ $endDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="card-title">{{ number_format($stats['total_kunjungan']) }}</h3>
                    <p class="card-text text-muted">Total Kunjungan</p>
                    <small class="text-muted">
                        {{ Carbon::parse($startDate)->format('d M Y') }} - {{ Carbon::parse($endDate)->format('d M Y') }}
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h3 class="card-title">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</h3>
                    <p class="card-text text-muted">Total Pendapatan</p>
                    <small class="text-muted">Periode yang sama</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h3 class="card-title">{{ number_format($stats['total_pasien_baru']) }}</h3>
                    <p class="card-text text-muted">Pasien Baru</p>
                    <small class="text-muted">Periode yang sama</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h3 class="card-title">{{ number_format($stats['rata_kunjungan'], 1) }}</h3>
                    <p class="card-text text-muted">Rata-rata per Hari</p>
                    <small class="text-muted">Kunjungan harian</small>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Tabel Data -->
    <div class="row">
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="mb-3">10 Tindakan Terbanyak</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tindakan</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalTindakan = $tableData['tindakan']->sum('jumlah');
                            @endphp
                            @foreach($tableData['tindakan'] as $tindakan)
                            @php
                                $percentage = $totalTindakan > 0 ? ($tindakan->jumlah / $totalTindakan) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $tindakan->nama_tindakan }}</td>
                                <td class="text-end">{{ number_format($tindakan->jumlah) }}</td>
                                <td class="text-end">{{ number_format($percentage, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="mb-3">10 Obat Terbanyak</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Obat</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalObat = $tableData['obat']->sum('total');
                            @endphp
                            @foreach($tableData['obat'] as $obat)
                            @php
                                $percentage = $totalObat > 0 ? ($obat->total / $totalObat) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $obat->nama_obat }}</td>
                                <td class="text-end">{{ number_format($obat->total) }}</td>
                                <td class="text-end">{{ number_format($percentage, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="row mt-4">
    <div class="col-12 text-center">
        {{-- Form untuk Export Excel --}}
        <form action="{{ route('admin.laporan.export') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="hidden" name="export_type" value="excel">
            <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>
        </form>

        {{-- Form untuk Export PDF --}}
        <form action="{{ route('admin.laporan.export') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="hidden" name="export_type" value="pdf">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
        </form>
    </div>
</div>
</div>
@endsection



@push('styles')
<style>
    @media print {
        .sidebar, .sidebar-toggle, .btn {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
    }
</style>
@endpush