@extends('layouts.kasir')

@section('title', 'Pembayaran Pasien')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cash-register me-2"></i>Pembayaran Pasien
                    </h6>
                    <span class="badge bg-primary text-white">No. Transaksi: {{ $transaksi->id_transaksi }}</span>
                </div>
                <div class="card-body">
                    <!-- Data Pasien dan Transaksi -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pasien</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="35%">No. RM</th>
                                            <td>{{ $transaksi->pendaftaran->pasien->id_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Pasien</th>
                                            <td>{{ $transaksi->pendaftaran->pasien->nama_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $transaksi->pendaftaran->pasien->usia }} tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $transaksi->pendaftaran->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Informasi Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="35%">No. Pendaftaran</th>
                                            <td>{{ $transaksi->pendaftaran->no_reg }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Transaksi</th>
                                            <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dokter</th>
                                            <td>{{ $transaksi->dokter->nama_pegawai ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diagnosa</th>
                                            <td>{{ $transaksi->diagnosa }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Tagihan -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Detail Tagihan</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Tindakan Medis -->
                                    <h6 class="text-primary mb-3"><i class="fas fa-procedures me-2"></i>Tindakan Medis</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Tindakan</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaksi->tindakan as $index => $tindakan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $tindakan->nama_tindakan }}</td>
                                                    <td class="text-end">Rp {{ number_format($tindakan->biaya, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                                @if($transaksi->tindakan->count() == 0)
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Tidak ada tindakan</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Obat -->
                                    @if($transaksi->obat->count() > 0)
                                    <h6 class="text-primary mb-3 mt-4"><i class="fas fa-pills me-2"></i>Resep Obat</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaksi->obat as $index => $obat)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $obat->nama_obat }}</td>
                                                    <td class="text-center">{{ $obat->jumlah }}</td>
                                                    <td class="text-end">Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}</td>
                                                    <td class="text-end">Rp {{ number_format($obat->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif

                                    <!-- Total Tagihan -->
                                    <div class="row mt-4">
                                        <div class="col-md-6 offset-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="bg-light">Total Tindakan</th>
                                                        <td class="text-end fw-bold">Rp {{ number_format($transaksi->tindakan->sum('biaya'), 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-light">Total Obat</th>
                                                        <td class="text-end fw-bold">Rp {{ number_format($transaksi->obat->sum('subtotal'), 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr class="table-primary">
                                                        <th class="bg-primary text-white">TOTAL TAGIHAN</th>
                                                        <td class="text-end fw-bold fs-5 text-danger">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pembayaran -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success text-white py-2">
                                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Form Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('kasir.pembayaran.proses', $transaksi->id_transaksi) }}" id="formPembayaran">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Total Tagihan</label>
                                                    <div class="form-control bg-light fw-bold fs-4 text-danger">
                                                        Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="metode_pembayaran" class="form-label fw-bold">Metode Pembayaran</label>
                                                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                                        <option value="">Pilih Metode</option>
                                                        <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                                        <option value="debit" {{ old('metode_pembayaran') == 'debit' ? 'selected' : '' }}>Kartu Debit</option>
                                                        <option value="kredit" {{ old('metode_pembayaran') == 'kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                                    </select>
                                                    @error('metode_pembayaran')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3" id="fieldNoReferensi" style="display: none;">
                                                    <label for="no_referensi" class="form-label">No. Referensi</label>
                                                    <input type="text" class="form-control" id="no_referensi" name="no_referensi" 
                                                           value="{{ old('no_referensi') }}" placeholder="Masukkan no. referensi">
                                                    @error('no_referensi')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="jumlah_bayar" class="form-label fw-bold">Jumlah Bayar</label>
                                                    <input type="number" class="form-control form-control-lg fs-4" 
                                                           id="jumlah_bayar" name="jumlah_bayar" 
                                                           value="{{ old('jumlah_bayar') }}" 
                                                           min="{{ $transaksi->total_biaya }}" 
                                                           step="500" required
                                                           placeholder="Masukkan jumlah bayar">
                                                    @error('jumlah_bayar')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Kembalian</label>
                                                    <div class="form-control bg-light fw-bold fs-4 text-success" id="kembalian">
                                                        Rp 0
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan (Optional)</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" 
                                                              rows="2" placeholder="Tambahkan keterangan jika perlu">{{ old('keterangan') }}</textarea>
                                                    @error('keterangan')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('kasir.tagihan') }}" class="btn btn-secondary">
                                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                                    </a>
                                                    <button type="submit" class="btn btn-success btn-lg">
                                                        <i class="fas fa-check-circle me-2"></i>Proses Pembayaran
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
    
    .table th {
        background-color: #f8f9fa;
    }
    
    #jumlah_bayar {
        font-weight: bold;
        border: 2px solid #2b6777;
    }
    
    #kembalian {
        border: 2px solid #28a745;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        const totalTagihan = {{ $transaksi->total_biaya }};
        
        // Hitung kembalian
        function hitungKembalian() {
            const jumlahBayar = parseFloat($('#jumlah_bayar').val()) || 0;
            const kembalian = jumlahBayar - totalTagihan;
            
            if (kembalian >= 0) {
                $('#kembalian').text('Rp ' + kembalian.toLocaleString('id-ID')).removeClass('text-danger').addClass('text-success');
            } else {
                $('#kembalian').text('Rp ' + kembalian.toLocaleString('id-ID')).removeClass('text-success').addClass('text-danger');
            }
        }
        
        // Toggle field no referensi
        function toggleFieldReferensi() {
            const metode = $('#metode_pembayaran').val();
            if (metode === 'transfer' || metode === 'debit' || metode === 'kredit') {
                $('#fieldNoReferensi').show();
                $('#no_referensi').prop('required', true);
            } else {
                $('#fieldNoReferensi').hide();
                $('#no_referensi').prop('required', false);
            }
        }
        
        // Event listeners
        $('#jumlah_bayar').on('input', hitungKembalian);
        $('#metode_pembayaran').change(toggleFieldReferensi);
        
        // Validasi form
        $('#formPembayaran').on('submit', function(e) {
            const jumlahBayar = parseFloat($('#jumlah_bayar').val()) || 0;
            
            if (jumlahBayar < totalTagihan) {
                e.preventDefault();
                alert('Jumlah pembayaran kurang dari total tagihan!');
                $('#jumlah_bayar').focus();
                return false;
            }
            
            // Tampilkan loading
            $('button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');
            
            return true;
        });
        
        // Inisialisasi
        hitungKembalian();
        toggleFieldReferensi();
    });
</script>
@endpush