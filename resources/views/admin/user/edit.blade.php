@extends('layouts.admin')

@section('content')
<h1>Edit User</h1>

<form action="{{ route('admin.user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
    </div>
    <div class="form-group">
        <label>Password Baru (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="form-group">
        <label>Role</label>
        <input type="number" name="id_role" class="form-control" value="{{ $user->id_role }}" required>
    </div>
    <button type="submit" class="btn btn-success mt-2">Update</button>
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
