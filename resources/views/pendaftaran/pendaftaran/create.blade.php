@extends('layouts.pendaftaran')

@section('title', 'Tambah Pendaftaran')


@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">Form Pendaftaran Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pendaftaran.pendaftaran.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_reg">Nomor Registrasi</label>
                        <input type="text" class="form-control" id="no_reg" name="no_reg" 
                               value="{{ old('no_reg', $noReg) }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tgl_daftar">Tanggal Daftar</label>
                        <input type="datetime-local" class="form-control" id="tgl_daftar" 
                               name="tgl_daftar" value="{{ old('tgl_daftar', now()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="id_pasien">Pasien</label>
                <select class="form-control select2" id="id_pasien" name="id_pasien" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($pasien as $p)
                    <option value="{{ $p->id_pasien }}" {{ old('id_pasien') == $p->id_pasien ? 'selected' : '' }}>
                        {{ $p->no_rm }} - {{ $p->nama_pasien }} ({{ $p->jk == 'L' ? 'L' : 'P' }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_kunjungan">Jenis Kunjungan</label>
                        <select class="form-control" id="jenis_kunjungan" name="jenis_kunjungan" required>
                            <option value="baru" {{ old('jenis_kunjungan') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="lama" {{ old('jenis_kunjungan') == 'lama' ? 'selected' : '' }}>Lama</option>
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea class="form-control" id="keluhan" name="keluhan" rows="2">{{ old('keluhan') }}</textarea>
            </div>

            

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pendaftaran.pendaftaran.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih pasien...",
            allowClear: true
        });
    });
</script>
@endpush