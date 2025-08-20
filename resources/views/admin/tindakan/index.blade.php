@extends('layouts.admin')
@section('content')
<h1>Data Tindakan</h1>

<a href="{{ route('admin.tindakan.create') }}" class="btn btn-primary mb-3">Tambah Tindakan</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Tindakan</th>
            <th>Biaya</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tindakan as $t)
        <tr>
            <td>{{ $t->id_tindakan }}</td>
            <td>{{ $t->nama_tindakan }}</td>
            <td>{{ number_format($t->biaya_tindakan,2,',','.') }}</td>
            <td>
                <a href="{{ route('admin.tindakan.edit', $t->id_tindakan) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.tindakan.destroy', $t->id_tindakan) }}" method="POST" style="display:inline-block;">
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
