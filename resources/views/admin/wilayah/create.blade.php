@extends('layouts.admin')


@section('content')
<div class="container mt-4">
    <h4>Tambah Wilayah</h4>
    <form action="{{ route('admin.wilayah.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Wilayah</label>
            <input type="text" name="nama_wilayah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="provinsi">Provinsi</option>
                <option value="kabupaten">Kabupaten</option>
                <option value="kota">Kota</option>
                <option value="kecamatan">Kecamatan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.wilayah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
