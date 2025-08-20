<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $pembayaran->id_pembayaran }}</title>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .struk-container, .struk-container * {
                visibility: visible;
            }
            .struk-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        .struk-container {
            max-width: 300px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 12px;
            margin: 2px 0;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 12px;
        }
        
        .info-label {
            font-weight: bold;
            min-width: 100px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .double-divider {
            border-top: 2px solid #000;
            margin: 15px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 12px;
        }
        
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 3px 0;
            border-bottom: 1px dotted #ccc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .total-section {
            margin: 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #000;
            font-size: 11px;
            color: #666;
        }
        
        .thank-you {
            font-style: italic;
            margin: 15px 0;
            text-align: center;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Libre Barcode 128', cursive;
            font-size: 24px;
        }
        
        .print-buttons {
            margin-top: 20px;
            text-align: center;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        
        .btn-print {
            background-color: #007bff;
            color: white;
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-print:hover {
            background-color: #0056b3;
        }
        
        .btn-back:hover {
            background-color: #545b62;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-lunas {
            background-color: #28a745;
            color: white;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="no-print print-buttons">
        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        
    </div>

    <div class="struk-container">
        <!-- Header -->
        <div class="header">
            <h1>KLINIK SEHAT BERSAMA</h1>
            <p>Jl. Kesehatan No. 123, Jakarta</p>
            <p>Telp: (021) 1234-5678</p>
            <p>www.kliniksehatbersama.com</p>
        </div>

        <!-- Informasi Transaksi -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">No. Struk:</span>
                <span>{{ $pembayaran->id_pembayaran }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kasir:</span>
                <span>{{ $pembayaran->pegawai->nama_pegawai ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="status-badge status-{{ $pembayaran->status_pembayaran }}">
                    {{ strtoupper($pembayaran->status_pembayaran) }}
                </span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Informasi Pasien -->
        <div class="info-section">
            
            <div class="info-row">
                <span class="info-label">Nama Pasien:</span>
                <span>{{ $pembayaran->transaksi->pendaftaran->pasien->nama_pasien ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dokter:</span>
                <span>{{ $pembayaran->transaksi->pegawai->nama_pegawai ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Detail Tindakan -->
        <h4 class="text-center">TINDAKAN MEDIS</h4>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-right">Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaran->transaksi->tindakan as $tindakan)
                <tr>
                    <td>{{ $tindakan->nama_tindakan }}</td>
                    <td class="text-right">Rp {{ number_format($tindakan->biaya, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                @if($pembayaran->transaksi->tindakan->count() == 0)
                <tr>
                    <td colspan="2" class="text-center">- Tidak ada tindakan -</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Detail Obat -->
        @if($pembayaran->transaksi->obat->count() > 0)
        <div class="divider"></div>
        <h4 class="text-center">RESEP OBAT</h4>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaran->transaksi->obat as $obat)
                <tr>
                    <td>{{ $obat->nama_obat }}</td>
                    <td>{{ $obat->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($obat->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div class="double-divider"></div>

        <!-- Total Pembayaran -->
        <div class="total-section">
            <div class="info-row">
                <span class="info-label">Total Tindakan:</span>
                <span class="text-right">Rp {{ number_format($pembayaran->transaksi->tindakan->sum('biaya'), 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Obat:</span>
                <span class="text-right">Rp {{ number_format($pembayaran->transaksi->obat->sum('subtotal'), 0, ',', '.') }}</span>
            </div>
            <div class="info-row text-bold">
                <span class="info-label">TOTAL TAGIHAN:</span>
                <span class="text-right">Rp {{ number_format($pembayaran->total_tagihan, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jumlah Bayar:</span>
                <span class="text-right">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kembalian:</span>
                <span class="text-right">Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode:</span>
                <span class="text-right text-bold">{{ strtoupper($pembayaran->metode_pembayaran) }}</span>
            </div>
            @if($pembayaran->no_referensi)
            <div class="info-row">
                <span class="info-label">No. Referensi:</span>
                <span class="text-right">{{ $pembayaran->no_referensi }}</span>
            </div>
            @endif
        </div>

        
        <div class="barcode">
            *{{ $pembayaran->id_pembayaran }}*
        </div>

       
        <div class="thank-you">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Semoga lekas sembuh</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Struk ini sebagai bukti pembayaran yang sah</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan</p>
            <p>www.kliniksehatbersama.com</p>
        </div>
    </div>

    <script>
        
        window.onload = function() {
            // Optional: auto print after 1 second
            // setTimeout(function() {
            //     window.print();
            // }, 1000);
        };

        // After print, go back or close window
        window.afterPrint = function() {
            // Optional: redirect back after printing
            // window.history.back();
        };
    </script>
</body>
</html>