@extends('layouts.admin')
@section('content')
<h1>Tambah Tindakan</h1>

<form action="{{ route('admin.tindakan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Nama Tindakan</label>
        <input type="text" name="nama_tindakan" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Biaya Tindakan</label>
        <input type="number" step="0.01" name="biaya_tindakan" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success mt-2">Simpan</button>
</form>
@endsection
