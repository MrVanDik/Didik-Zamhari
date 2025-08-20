@extends('layouts.admin')

@section('content')
<h1>Data User</h1>

<a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-3">Tambah User</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->id_role }}</td>
            <td>
                <a href="{{ route('admin.user.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" style="display:inline-block;">
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
