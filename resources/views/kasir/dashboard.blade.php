@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="stat-number">Rp {{ number_format($total_tagihan_hari_ini, 0, ',', '.') }}</div>
                <div class="stat-label">Total Tagihan Hari Ini</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-number">Rp {{ number_format($total_pembayaran_hari_ini, 0, ',', '.') }}</div>
                <div class="stat-label">Pembayaran Hari Ini</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $tagihan_pending }}</div>
                <div class="stat-label">Tagihan Pending</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $pembayaran_berhasil }}</div>
                <div class="stat-label">Pembayaran Berhasil</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Transaksi Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-receipt me-2"></i>Transaksi Terbaru</h6>
                <a href="{{ route('kasir.tagihan') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi_terbaru as $transaksi)
                            <tr>
                                <td>{{ $transaksi->pendaftaran->pasien->id_pasien }}</td>
                                <td>{{ $transaksi->pendaftaran->pasien->nama_pasien }}</td>
                                <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $transaksi->pembayaran ? 'success' : 'warning' }}">
                                        {{ $transaksi->pembayaran ? 'Lunas' : 'Pending' }}
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

    <!-- Pembayaran Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-history me-2"></i>Pembayaran Terbaru</h6>
                <a href="{{ route('kasir.riwayat') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayaran_terbaru as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->transaksi->pendaftaran->pasien->id_pasien }}</td>
                                <td>{{ $pembayaran->transaksi->pendaftaran->pasien->nama_pasien }}</td>
                                <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($pembayaran->metode_pembayaran) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection