@extends('layouts.admin')

@section('content')
<h1>Tambah User</h1>

<form action="{{ route('admin.user.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Pilih Pegawai</label>
        <select name="id_pegawai" class="form-control" required>
            <option value="">-- Pilih Pegawai --</option>
            @foreach($pegawai as $p)
                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }} ({{ $p->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="id_role" class="form-control" required>
            <option value="1">Admin</option>
            <option value="2">Pendaftaran</option>
            <option value="3">Dokter</option>
            <option value="4">Kasir</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success mt-2">Simpan</button>
</form>
@endsection
