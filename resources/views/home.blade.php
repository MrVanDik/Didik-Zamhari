@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
  <h3 class="mb-4">📊 Dashboard Klinik</h3>

  <!-- Statistik Cards -->
  <div class="row">
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-primary text-white rounded-3">
        <h5>Kunjungan Hari Ini</h5>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-success text-white rounded-3">
        <h5>Kunjungan Bulan Ini</h5>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-warning text-dark rounded-3">
        <h5>Tindakan Terbanyak</h5>
        <h2>{{ $tindakan_terbanyak->nama ?? '-' }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3 bg-danger text-white rounded-3">
        <h5>Obat Terfavorit</h5>
        <h2>{{ $obat_terbanyak->nama ?? '-' }}</h2>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card shadow-sm p-3">
        <h5>📈 Grafik Kunjungan Pasien</h5>
        <canvas id="chartKunjungan"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm p-3">
        <h5>💊 Obat Paling Banyak Diresepkan</h5>
        <canvas id="chartObat"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
