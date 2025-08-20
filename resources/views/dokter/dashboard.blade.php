@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="row fade-in-up">
    <!-- Statistics Cards -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $total_pasien_hari_ini }}</div>
                <div class="stat-label">Pasien Hari Ini</div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-number">{{ $total_pasien_bulan_ini }}</div>
                <div class="stat-label">Pasien Bulan Ini</div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-body stat-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $antrian_menunggu }}</div>
                <div class="stat-label">Antrian Menunggu</div>
            </div>
        </div>
    </div>

    
</div>

<div class="row">
    <!-- Antrian Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-list me-2"></i>Antrian Terbaru</h6>
                <a href="{{ route('dokter.antrian') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrian_terbaru as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pasien->nama_pasien }}</td>
                                <td>{{ $item->created_at->format('H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'proses' ? 'info' : 'warning') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status == 'antri')
                                    <a href="#" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fs-1 mb-2"></i>
                                    <p>Tidak ada antrian saat ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($aktivitas_terbaru as $aktivitas)
					    <div class="timeline-item mb-3">
					        <div class="timeline-content">
					            <div class="d-flex justify-content-between align-items-start mb-1">
					                <span class="fw-bold text-dark">{{ $aktivitas->pasien->nama_pasien ?? 'N/A' }}</span>
					                <small class="text-muted">{{ $aktivitas->created_at->diffForHumans() }}</small>
					            </div>
					            <p class="mb-1 text-muted small">{{ $aktivitas->diagnosa ?? 'Tidak ada diagnosa' }}</p>
					            
					            @if($aktivitas->tindakan && count($aktivitas->tindakan) > 0)
					                <div class="d-flex gap-1">
					                    @foreach($aktivitas->tindakan as $tindakan)
					                        <span class="badge bg-primary bg-opacity-10 text-primary small">
					                            {{ $tindakan->nama_tindakan ?? 'Tindakan' }}
					                        </span>
					                    @endforeach
					                </div>
					            @else
					                <div class="text-muted small">
					                    <i class="fas fa-info-circle"></i> Tidak ada tindakan tercatat
					                </div>
					            @endif
					        </div>
					    </div>
					@empty
					    <div class="text-center text-muted py-4">
					        <i class="fas fa-clock fs-1 mb-2"></i>
					        <p>Belum ada aktivitas</p>
					    </div>
					@endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik Kunjungan Pasien -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-line me-2"></i>Grafik Kunjungan Pasien (7 Hari Terakhir)</h6>
            </div>
            <div class="card-body">
                <canvas id="visitorChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Grafik Kunjungan Pasien
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafik_kunjungan['labels']) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode($grafik_kunjungan['data']) !!},
                    borderColor: '#2b6777',
                    backgroundColor: 'rgba(43, 103, 119, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Auto refresh setiap 30 detik untuk update antrian
        setInterval(function() {
            $.get('{{ route("dokter.index") }}', function(data) {
                // Update counter yang perlu di-refresh
                // Implementasi sesuai kebutuhan
            });
        }, 30000);
    });
</script>
@endpush