@extends('layouts.pendaftaran')

@section('title', 'Detail Pasien')

@section('content')

        <!-- Content -->
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i>Form Registrasi Pasien</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <form action="{{ route('pendaftaran.pasien.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="id_pasien" class="form-control @error('id_pasien') is-invalid @enderror" required 
                                       placeholder="Masukkan NIK pasien" maxlength="16"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       value="{{ old('id_pasien') }}">
                                <small class="text-muted">Nomor Induk Kependudukan (16 digit)</small>
                                @error('id_pasien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pasien" class="form-control @error('nama_pasien') is-invalid @enderror" required 
                                       placeholder="Masukkan nama lengkap pasien"
                                       value="{{ old('nama_pasien') }}">
                                @error('nama_pasien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" 
                                       max="{{ date('Y-m-d') }}"
                                       value="{{ old('tgl_lahir') }}">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jk" class="form-select @error('jk') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Wilayah</label>
                                <select name="id_wilayah" class="form-select @error('id_wilayah') is-invalid @enderror">
                                    <option value="">Pilih Wilayah</option>
                                    @foreach($wilayah as $w)
                                        <option value="{{ $w->id_wilayah }}" {{ old('id_wilayah') == $w->id_wilayah ? 'selected' : '' }}>
                                            {{ $w->nama_wilayah }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_wilayah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" 
                                      placeholder="Masukkan alamat lengkap pasien">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('pendaftaran.pasien.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Validasi NIK harus 16 digit
    document.querySelector('form').addEventListener('submit', function(e) {
        const nikInput = document.querySelector('input[name="id_pasien"]');
        if (nikInput.value.length !== 16) {
            alert('NIK harus terdiri dari 16 digit angka');
            e.preventDefault();
            nikInput.focus();
        }
    });

    // Auto close notifikasi setelah 5 detik
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
@endpush
