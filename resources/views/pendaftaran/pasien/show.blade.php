@extends('layouts.pendaftaran')

@section('title', 'Detail Pasien')
@include('layouts.partials.sidebar')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">
            <i class="fas fa-user mr-2"></i> Detail Pasien
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">NIK</dt>
                    <dd class="col-sm-8">{{ $pasien->id_pasien }}</dd>

                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $pasien->nama_pasien }}</dd>

                    <dt class="col-sm-4">Jenis Kelamin</dt>
                    <dd class="col-sm-8">{{ $pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">Tanggal Lahir</dt>
                    <dd class="col-sm-8">{{ $pasien->tgl_lahir->format('d/m/Y') }}</dd>

                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $pasien->alamat }}</dd>

                    <dt class="col-sm-4">Terdaftar Sejak</dt>
                    <dd class="col-sm-8">{{ $pasien->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('pendaftaran.pasien.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection