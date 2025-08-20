@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Edit Wilayah</h4>
    <form action="{{ route('admin.wilayah.update', $wilayah->id_wilayah) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Wilayah</label>
            <input type="text" name="nama_wilayah" class="form-control" value="{{ $wilayah->nama_wilayah }}" required>
        </div>
        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="provinsi" {{ $wilayah->tipe == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                <option value="kabupaten" {{ $wilayah->tipe == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                <option value="kota" {{ $wilayah->tipe == 'kota' ? 'selected' : '' }}>Kota</option>
                <option value="kecamatan" {{ $wilayah->tipe == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.wilayah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
