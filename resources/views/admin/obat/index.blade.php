@extends('layouts.admin')
@section('content')
<h1>Data Obat</h1>

<a href="{{ route('admin.obat.create') }}" class="btn btn-primary mb-3">Tambah Obat</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Nama Obat</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($obat as $o)
        <tr>
            <!-- <td>{{ $o->id_obat }}</td> -->
            <td>{{ $o->nama_obat }}</td>
            <td>{{ number_format($o->harga_obat,2,',','.') }}</td>
            <td>{{ $o->stok }}</td>
            <td>
                <a href="{{ route('admin.obat.edit', $o->id_obat) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.obat.destroy', $o->id_obat) }}" method="POST" style="display:inline-block;">
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
