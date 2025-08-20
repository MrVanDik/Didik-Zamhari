@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Data Wilayah</h4>
    <a href="{{ route('admin.wilayah.create') }}" class="btn btn-primary mb-3">+ Tambah Wilayah</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Wilayah</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wilayah as $w)
            <tr>
                <td>{{ $w->id_wilayah }}</td>
                <td>{{ $w->nama_wilayah }}</td>
                <td>{{ ucfirst($w->tipe) }}</td>
                <td>
                    <a href="{{ route('admin.wilayah.edit', $w->id_wilayah) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.wilayah.destroy', $w->id_wilayah) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
