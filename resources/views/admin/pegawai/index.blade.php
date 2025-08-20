@extends('layouts.admin')

@section('content')
<h1>Data Pegawai</h1>

<a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>No. Telp</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pegawai as $p)
        <tr>
            <td>{{ $p->id_pegawai }}</td>
            <td>{{ $p->nama_pegawai }}</td>
            <td>{{ $p->jabatan }}</td>
            <td>{{ $p->no_telp }}</td>
            <td>
                <a href="{{ route('admin.pegawai.edit', $p->id_pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.pegawai.destroy', $p->id_pegawai) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
