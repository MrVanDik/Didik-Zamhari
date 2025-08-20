<!-- resources/views/dokter/transaksi.blade.php -->
@extends('layouts.dokter')

@section('title', 'Transaksi Pasien')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-notes-medical me-2"></i>Transaksi Pasien
                    </h6>
                    <span class="badge bg-primary text-white">No. RM: {{ $pendaftaran->pasien->id_pasien }}</span>
                </div>
                <div class="card-body">
                    <!-- Data Pasien -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pasien</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="35%">Nama Pasien</th>
                                            <td>{{ $pendaftaran->pasien->nama_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. RM</th>
                                            <td>{{ $pendaftaran->pasien->id_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $pendaftaran->pasien->usia }} tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $pendaftaran->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $pendaftaran->pasien->alamat }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-calendar me-2"></i>Data Kunjungan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="35%">No. Pendaftaran</th>
                                            <td>{{ $pendaftaran->no_reg }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Daftar</th>
                                            <td>{{ $pendaftaran->tgl_daftar->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kunjungan</th>
                                            <td>
                                                <span class="badge bg-{{ $pendaftaran->jenis_kunjungan == 'baru' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($pendaftaran->jenis_kunjungan) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge bg-{{ $pendaftaran->status == 'selesai' ? 'success' : ($pendaftaran->status == 'proses' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($pendaftaran->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Keluhan</th>
                                            <td>{{ $pendaftaran->keluhan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Transaksi -->
                    <form method="POST" action="{{ route('dokter.transaksi.simpan') }}" id="transaksiForm">
                        @csrf
                        <input type="hidden" name="id_daftar" value="{{ $pendaftaran->id_daftar }}">

                        <!-- Diagnosa -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-primary text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Diagnosa</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="diagnosa" class="form-label">Diagnosa Pasien</label>
                                            <textarea class="form-control" id="diagnosa" name="diagnosa" 
                                                      rows="3" placeholder="Masukkan diagnosa pasien..." required>{{ old('diagnosa') }}</textarea>
                                            @error('diagnosa')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tindakan dan Obat -->
                        <div class="row">
                            <!-- Tindakan Medis -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-procedures me-2"></i>Tindakan Medis</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($tindakan->count() > 0)
                                            @foreach($tindakan as $t)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input tindakan-checkbox" type="checkbox" 
                                                       name="tindakan[]" id="tindakan{{ $t->id_tindakan }}" 
                                                       value="{{ $t->id_tindakan }}" data-biaya="{{ $t->biaya_tindakan }}">
                                                <label class="form-check-label d-flex justify-content-between w-100" for="tindakan{{ $t->id_tindakan }}">
                                                    <span>{{ $t->nama_tindakan }}</span>
                                                    <span class="text-success fw-bold">Rp {{ number_format($t->biaya_tindakan, 0, ',', '.') }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted py-3">
                                                <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                                <p>Belum ada data tindakan medis</p>
                                            </div>
                                        @endif
                                        @error('tindakan')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Resep Obat -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-warning text-dark py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="fas fa-pills me-2"></i>Resep Obat</h6>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAllObat">
                                                <label class="form-check-label small" for="selectAllObat">Pilih Semua</label>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" class="form-control form-control-sm" id="searchObat" 
                                                   placeholder="Cari obat...">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($obat->count() > 0)
                                            @foreach($obat as $index => $o)
                                            <div class="row mb-3 align-items-center obat-item">
                                                <div class="col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input obat-checkbox" type="checkbox" 
                                                               name="obat[]" id="obat{{ $o->id_obat }}" 
                                                               value="{{ $o->id_obat }}" data-harga="{{ $o->harga_obat }}"
                                                               data-stok="{{ $o->stok }}">
                                                        <label class="form-check-label" for="obat{{ $o->id_obat }}">
                                                            <strong>{{ $o->nama_obat }}</strong>
                                                            <small class="text-muted d-block">{{ $o->jenis_obat }}</small>
                                                            <small class="text-success d-block">Rp {{ number_format($o->harga_obat, 0, ',', '.') }}</small>
                                                            @if($o->keterangan)
                                                            <small class="text-info d-block">{{ Str::limit($o->keterangan, 50) }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control jumlah-obat" 
                                                               name="jumlah_obat[]" min="1" max="{{ $o->stok }}" 
                                                               disabled data-max="{{ $o->stok }}"
                                                               placeholder="Jumlah" value="1">
                                                        <span class="input-group-text bg-light">
                                                            Stok: {{ $o->stok }}
                                                        </span>
                                                    </div>
                                                    @if($o->expired_date)
                                                    <small class="text-muted d-block mt-1">
                                                        Exp: {{ \Carbon\Carbon::parse($o->expired_date)->format('d/m/Y') }}
                                                    </small>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted py-3">
                                                <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                                <p>Tidak ada obat yang tersedia</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Biaya -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Ringkasan Biaya</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Biaya Tindakan:</span>
                                                    <span id="totalTindakan">Rp 0</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Biaya Obat:</span>
                                                    <span id="totalObat">Rp 0</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold fs-5">
                                                    <span>Total Biaya:</span>
                                                    <span id="totalBiaya">Rp 0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dokter.antrian') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Antrian
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Transaksi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-check-input:checked {
        background-color: #2b6777;
        border-color: #2b6777;
    }
    
    .jumlah-obat:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    
    #totalBiaya {
        color: #2b6777;
        font-weight: 700;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        let totalTindakan = 0;
        let totalObat = 0;
        let totalBiaya = 0;

        // Fungsi update total biaya
        function updateTotalBiaya() {
            totalTindakan = 0;
            totalObat = 0;
            
            // Hitung total tindakan
            $('.tindakan-checkbox:checked').each(function() {
                const biaya = parseFloat($(this).data('biaya')) || 0;
                totalTindakan += biaya;
            });
            
            // Hitung total obat
            $('.obat-checkbox:checked').each(function() {
                const harga = parseFloat($(this).data('harga')) || 0;
                const jumlahInput = $(this).closest('.row').find('.jumlah-obat');
                const jumlah = parseInt(jumlahInput.val()) || 0;
                totalObat += harga * jumlah;
            });
            
            totalBiaya = totalTindakan + totalObat;
            
            // Update tampilan
            $('#totalTindakan').text('Rp ' + totalTindakan.toLocaleString('id-ID'));
            $('#totalObat').text('Rp ' + totalObat.toLocaleString('id-ID'));
            $('#totalBiaya').text('Rp ' + totalBiaya.toLocaleString('id-ID'));
            
            console.log('Tindakan:', totalTindakan, 'Obat:', totalObat, 'Total:', totalBiaya);
        }

        // Enable/disable jumlah obat berdasarkan checkbox
        $('.obat-checkbox').change(function() {
            const jumlahInput = $(this).closest('.row').find('.jumlah-obat');
            if ($(this).is(':checked')) {
                jumlahInput.prop('disabled', false);
                jumlahInput.val(1);
            } else {
                jumlahInput.prop('disabled', true);
                jumlahInput.val('');
            }
            updateTotalBiaya();
        });

        // Update biaya ketika jumlah obat diubah
        $('.jumlah-obat').on('change input', function() {
            const max = $(this).data('max');
            let value = parseInt($(this).val()) || 0;
            
            if (value > max) {
                alert('Jumlah melebihi stok yang tersedia!');
                $(this).val(max);
                value = max;
            }
            
            if (value < 1) {
                $(this).val(1);
                value = 1;
            }
            
            updateTotalBiaya();
        });

        // Update biaya ketika tindakan diubah
        $('.tindakan-checkbox').change(function() {
            updateTotalBiaya();
        });

        // Pencarian obat
        $('#searchObat').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            
            $('.obat-item').each(function() {
                const text = $(this).find('.form-check-label').text().toLowerCase();
                if (text.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Select all obat
        $('#selectAllObat').change(function() {
            $('.obat-checkbox').prop('checked', $(this).is(':checked')).trigger('change');
        });

        // Inisialisasi pertama kali
        updateTotalBiaya();

        // Validasi form sebelum submit
        $('#transaksiForm').on('submit', function(e) {
            const diagnosa = $('#diagnosa').val().trim();
            const tindakanChecked = $('.tindakan-checkbox:checked').length;
            
            if (!diagnosa) {
                e.preventDefault();
                alert('Diagnosa harus diisi!');
                $('#diagnosa').focus();
                return false;
            }
            
            if (tindakanChecked === 0) {
                e.preventDefault();
                alert('Pilih minimal satu tindakan medis!');
                return false;
            }

            // Validasi obat
            let obatError = false;
            $('.obat-checkbox:checked').each(function() {
                const jumlahInput = $(this).closest('.row').find('.jumlah-obat');
                const jumlah = parseInt(jumlahInput.val()) || 0;
                const stok = parseInt($(this).data('stok')) || 0;
                
                if (jumlah < 1) {
                    e.preventDefault();
                    alert('Jumlah obat harus minimal 1!');
                    jumlahInput.focus();
                    obatError = true;
                    return false;
                }
                
                if (jumlah > stok) {
                    e.preventDefault();
                    alert('Jumlah obat melebihi stok yang tersedia!');
                    jumlahInput.focus();
                    obatError = true;
                    return false;
                }
            });
            
            if (obatError) return false;

            // Tampilkan loading
            $('button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
            
            return true;
        });
    });
</script>
@endpush