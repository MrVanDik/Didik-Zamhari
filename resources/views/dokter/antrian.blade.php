@extends('layouts.dokter')

@section('title', 'Antrian Pasien')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Antrian Pasien Hari Ini</h6>
            <span class="badge bg-primary text-white">Total: {{ $antrian->count() }} Pasien</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Kunjungan</th>
                            <th>Waktu Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($antrian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->no_reg }}</td>
                            <td>{{ $item->pasien->nama_pasien }}</td>
                            <td>
                                <span class="badge bg-{{ $item->enis_kunjungan == 'baru' ? 'info' : 'warning' }}">
                                    {{ ucfirst($item->jenis_kunjungan) }}
                                </span>
                            </td>
                            <td>{{ $item->tgl_daftar->format('H:i') }}</td>
                            <td>
                                <a href="{{ route('dokter.transaksi.view', $item->id_daftar) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-notes-medical"></i> Proses
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection