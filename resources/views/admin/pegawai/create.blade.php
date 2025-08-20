@extends('layouts.admin')
@section('content')
<h1>Tambah Pegawai</h1>

<form action="{{ route('admin.pegawai.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Nama Pegawai</label>
        <input type="text" name="nama_pegawai" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control" required>
    </div>

    <div class="form-group">
        <label>No. Telp</label>
        <input type="text" name="no_telp" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success mt-2">Simpan</button>
</form>

@endsection
