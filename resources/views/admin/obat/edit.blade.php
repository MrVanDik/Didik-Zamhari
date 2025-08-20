@extends('layouts.admin')

@section('content')
<h1>Edit Obat</h1>

<form action="{{ route('admin.obat.update', $obat->id_obat) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-header py-3">
            <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Edit Data Obat</h5>
        </div>
        <div class="card-body">

            <!-- Kode & Nama Obat -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_obat" class="form-label">Kode Obat</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                        <input type="text" name="kode_obat" class="form-control" id="kode_obat"
                               value="{{ old('kode_obat', $obat->kode_obat) }}" maxlength="10">
                    </div>
                    @error('kode_obat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                        <input type="text" name="nama_obat" class="form-control" id="nama_obat" required
                               value="{{ old('nama_obat', $obat->nama_obat) }}">
                    </div>
                    @error('nama_obat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Jenis & Harga Obat -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_obat" class="form-label">Jenis Obat</label>
                    <select name="jenis_obat" class="form-select" id="jenis_obat">
                        <option value="">Pilih Jenis Obat</option>
                        @foreach(['Tablet','Kapsul','Sirup','Salep','Injeksi','Drop','Inhaler','Suppositoria'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_obat', $obat->jenis_obat) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_obat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="harga_obat" class="form-label">Harga Obat <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" step="0.01" name="harga_obat" class="form-control" id="harga_obat" required
                               value="{{ old('harga_obat', $obat->harga_obat) }}" min="0">
                    </div>
                    @error('harga_obat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tanggal Kadaluarsa & Stok -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="expired_date" class="form-label">Tanggal Kadaluarsa</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                        <input type="date" name="expired_date" class="form-control" id="expired_date"
                               value="{{ old('expired_date', $obat->expired_date ? $obat->expired_date->format('Y-m-d') : '') }}">
                    </div>
                    @error('expired_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                        <input type="number" name="stok" class="form-control" id="stok" required
                               value="{{ old('stok', $obat->stok) }}" min="0">
                    </div>
                    @error('stok')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" id="keterangan" rows="3">{{ old('keterangan', $obat->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol aksi -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Update
                </button>
            </div>

        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const expiredDateInput = document.getElementById('expired_date');
    expiredDateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        this.setCustomValidity(selectedDate <= today ? 'Tanggal kadaluarsa harus lebih dari hari ini.' : '');
    });

    const hargaInput = document.getElementById('harga_obat');
    hargaInput.addEventListener('change', function() {
        this.setCustomValidity(this.value < 0 ? 'Harga tidak boleh negatif.' : '');
    });

    const stokInput = document.getElementById('stok');
    stokInput.addEventListener('change', function() {
        this.setCustomValidity(this.value < 0 ? 'Stok tidak boleh negatif.' : '');
    });
});
</script>
@endsection
