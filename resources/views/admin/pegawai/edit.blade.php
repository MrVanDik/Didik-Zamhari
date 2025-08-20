@extends('layouts.admin')

@section('content')
<h1>Edit Pegawai</h1>

    <form action="{{ route('admin.pegawai.update', $pegawai->id_pegawai) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama pegawai</label>
            <input type="text" name="nama_pegawai" class="form-control" value="{{ $pegawai->nama_pegawai }}" required>
        </div>
        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $pegawai->jabatan }}" required>
        </div>
        <div class="form-group">
            <label>No. Telp</label>
            <input type="text" name="no_telp" class="form-control" value="{{ $pegawai->no_telp }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
