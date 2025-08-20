@extends('layouts.kasir')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-2"></i>Riwayat Pembayaran
            </h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" id="btnFilter">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('kasir.tagihan') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Tagihan
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form (Awalnya Disembunyikan) -->
            <div class="card mb-4 d-none" id="filterCard">
                <div class="card-body">
                    <form method="GET" action="{{ route('kasir.riwayat') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode">
                                <option value="">Semua Metode</option>
                                <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="debit" {{ request('metode') == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="kredit" {{ request('metode') == 'kredit' ? 'selected' : '' }}>Kredit</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('kasir.riwayat') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Transaksi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $riwayat->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Pendapatan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($riwayat->sum('jumlah_bayar'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Rata-rata Transaksi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($riwayat->avg('jumlah_bayar') ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Transaksi Hari Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $transaksiHariIni }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Total Tagihan</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Kasir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $pembayaran)
                        <tr>
                            <td>{{ $riwayat->firstItem() + $index }}</td>
                            <td>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $pembayaran->transaksi->pendaftaran->pasien->nama_pasien ?? 'N/A' }}</td>
                            <td class="text-end">Rp {{ number_format($pembayaran->total_tagihan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($pembayaran->metode_pembayaran) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->status_pembayaran == 'lunas' ? 'success' : ($pembayaran->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($pembayaran->status_pembayaran) }}
                                </span>
                            </td>
                            <td>{{ $pembayaran->pegawai->nama_pegawai ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('kasir.struk.print', $pembayaran->id_pembayaran) }}" 
                                       class="btn btn-sm btn-info" title="Cetak Struk" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning" title="Detail" 
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $pembayaran->id_pembayaran }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $pembayaran->id_pembayaran }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detail Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Informasi Pembayaran</h6>
                                                <p><strong>No. Pembayaran:</strong> {{ $pembayaran->id_pembayaran }}</p>
                                                <p><strong>Tanggal:</strong> {{ $pembayaran->created_at->format('d/m/Y H:i') }}</p>
                                                <p><strong>Status:</strong> 
                                                    <span class="badge bg-{{ $pembayaran->status_pembayaran == 'lunas' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($pembayaran->status_pembayaran) }}
                                                    </span>
                                                </p>
                                                <p><strong>Metode:</strong> {{ ucfirst($pembayaran->metode_pembayaran) }}</p>
                                                @if($pembayaran->no_referensi)
                                                <p><strong>No. Referensi:</strong> {{ $pembayaran->no_referensi }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Detail Transaksi</h6>
                                                <p><strong>Total Tagihan:</strong> Rp {{ number_format($pembayaran->total_tagihan, 0, ',', '.') }}</p>
                                                <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                                <p><strong>Kembalian:</strong> Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</p>
                                                <p><strong>Kasir:</strong> {{ $pembayaran->pegawai->nama_pegawai ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        @if($pembayaran->keterangan)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6>Keterangan</h6>
                                                <p class="text-muted">{{ $pembayaran->keterangan }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <a href="{{ route('kasir.struk.print', $pembayaran->id_pembayaran) }}" 
                                           class="btn btn-primary" target="_blank">
                                            <i class="fas fa-print me-1"></i> Cetak Struk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada riwayat pembayaran</h5>
                                <p class="text-muted">Belum ada transaksi pembayaran yang tercatat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($riwayat->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $riwayat->firstItem() }} sampai {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} entri
                </div>
                <nav>
                    {{ $riwayat->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle filter card
        $('#btnFilter').click(function() {
            $('#filterCard').toggleClass('d-none');
        });

        // Auto close filter when clicked outside
        $(document).click(function(e) {
            if (!$(e.target).closest('#filterCard').length && 
                !$(e.target).is('#btnFilter') &&
                !$('#filterCard').hasClass('d-none')) {
                $('#filterCard').addClass('d-none');
            }
        });

        // Prevent filter card from closing when clicking inside
        $('#filterCard').click(function(e) {
            e.stopPropagation();
        });

        // Export functionality (bisa ditambahkan later)
        $('#btnExport').click(function() {
            alert('Fitur export akan segera tersedia!');
        });
    });
</script>
@endpush

@push('styles')
<style>
    .table th {
        background-color: #4e73df;
        color: white;
        font-weight: 600;
        text-align: center;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.8em;
        padding: 0.5em 0.75em;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush