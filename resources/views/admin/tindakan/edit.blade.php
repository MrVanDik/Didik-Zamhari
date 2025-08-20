@extends('admin.layouts.app')

@section('content')
<h1>Edit Tindakan</h1>

<form action="{{ route('admin.tindakan.update', $tindakan->id_tindakan) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama Tindakan</label>
        <input type="text" name="nama_tindakan" class="form-control" value="{{ $tindakan->nama_tindakan }}" required>
    </div>
    <div class="form-group">
        <label>Biaya Tindakan</label>
        <input type="number" step="0.01" name="biaya_tindakan" class="form-control" value="{{ $tindakan->biaya_tindakan }}" required>
    </div>
    <button type="submit" class="btn btn-success mt-2">Update</button>
</form>
@endsection
