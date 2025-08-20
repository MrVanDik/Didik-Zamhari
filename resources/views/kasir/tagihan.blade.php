@extends('layouts.kasir')

@section('title', 'Tagihan Pasien')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Daftar Tagihan Pasien</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Tagihan</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaksi->pendaftaran->pasien->id_pasien }}</td>
                        <td>{{ $transaksi->pendaftaran->pasien->nama_pasien }}</td>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold text-danger">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $transaksi->id_transaksi }}">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                        </td>
                        <td>
                            <a href="{{ route('kasir.pembayaran.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-cash-register"></i> Bayar
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $transaksi->id_transaksi }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Detail Tagihan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Data Pasien</h6>
                                            <p><strong>No. RM:</strong> {{ $transaksi->pendaftaran->pasien->id_pasien }}</p>
                                            <p><strong>Nama:</strong> {{ $transaksi->pendaftaran->pasien->nama_pasien }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Informasi Transaksi</h6>
                                            <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                                            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <h6 class="mt-4">Detail Tindakan</h6>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Tindakan</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaksi->tindakan as $tindakan)
                                            <tr>
                                                <td>{{ $tindakan->nama_tindakan }}</td>
                                                <td>Rp {{ number_format($tindakan->biaya, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if($transaksi->obat->count() > 0)
                                    <h6 class="mt-4">Detail Obat</h6>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Obat</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaksi->obat as $obat)
                                            <tr>
                                                <td>{{ $obat->nama_obat }}</td>
                                                <td>{{ $obat->jumlah }}</td>
                                                <td>Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($obat->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($tagihan->count() == 0)
        <div class="text-center py-5">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5>Tidak ada tagihan pending</h5>
            <p class="text-muted">Semua tagihan sudah terbayar</p>
        </div>
        @endif
    </div>
</div>
@endsection