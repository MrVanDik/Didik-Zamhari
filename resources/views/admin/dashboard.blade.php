@extends('layouts.admin')

@section('title', 'Dashboard Admin - Klinik App')

@section('content')
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="bi bi-graph-up me-2"></i>Laporan & Analitik</h4>
                
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="chart-container">
                <h5 class="mb-3">Kunjungan Pasien 6 Bulan Terakhir</h5>
                <canvas id="monthlyVisitChart" height="75"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-container">
                <h5 class="mb-3">Pendapatan 6 Bulan Terakhir</h5>
                <canvas id="revenueChart" height="165"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-6" style="max-width: 400px; max-height: 400px; margin: 0 auto;">
            <div class="chart-container">
                <h5 class="mb-3">5 Tindakan Medis Terbanyak</h5>
                <canvas id="topProceduresChart" height="75"></canvas>
                
                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tindakan</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalTindakan = array_sum($chart_tindakan['data']);
                                @endphp
                                @foreach($chart_tindakan['labels'] as $index => $label)
                                @php
                                    $percentage = $totalTindakan > 0 ? ($chart_tindakan['data'][$index] / $totalTindakan) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td class="text-end">{{ $chart_tindakan['data'][$index] }}</td>
                                    <td class="text-end">{{ number_format($percentage, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-6 " style="max-width: 400px; max-height: 400px; margin: 0 auto;">
            <div class="chart-container">
                <h5 class="mb-3">5 Obat Paling Sering Diresepkan</h5>
                <canvas id="topMedicinesChart" height="75"></canvas>
                
                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th class="text-end">Jumlah Resep</th>
                                    <th class="text-end">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalObat = array_sum($chart_obat['data']);
                                @endphp
                                @foreach($chart_obat['labels'] as $index => $label)
                                @php
                                    $percentage = $totalObat > 0 ? ($chart_obat['data'][$index] / $totalObat) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td class="text-end">{{ $chart_obat['data'][$index] }}</td>
                                    <td class="text-end">{{ number_format($percentage, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5"></div>
    <div class="row mb-5"></div>
    <div class="row mb-5"></div>


    

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
       
        const monthlyVisitCtx = document.getElementById('monthlyVisitChart').getContext('2d');
        const monthlyVisitChart = new Chart(monthlyVisitCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bulan_labels) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode($kunjungan_per_bulan) !!},
                    backgroundColor: 'rgba(52, 152, 219, 0.7)',
                    borderColor: '#3498db',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Kunjungan'
                        }
                    }
                }
            }
        });
        
        // Grafik Pendapatan
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($bulan_labels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($pendapatan_per_bulan) !!},
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: '#2ecc71',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Pendapatan'
                        }
                    }
                }
            }
        });
        
        const topProceduresCtx = document.getElementById('topProceduresChart').getContext('2d');
        const topProceduresChart = new Chart(topProceduresCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chart_tindakan['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chart_tindakan['data']) !!},
                    backgroundColor: [
                        '#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        
        const topMedicinesCtx = document.getElementById('topMedicinesChart').getContext('2d');
        const topMedicinesChart = new Chart(topMedicinesCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chart_obat['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chart_obat['data']) !!},
                    backgroundColor: [
                        '#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        document.querySelectorAll('.btn-group .btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.btn-group .btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
            });
        });
    });
</script>
@endpush