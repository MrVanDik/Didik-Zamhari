<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Pegawai;
use App\Models\TransaksiObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function dashboard()
    {
        

        $data = [
            'total_tagihan_hari_ini' => Transaksi::whereDoesntHave('pembayaran')
                ->whereDate('created_at', today())
                ->sum('total_biaya'),
                
            'total_pembayaran_hari_ini' => Pembayaran::hariIni()->lunas()->sum('jumlah_bayar'),
                
            'tagihan_pending' => Transaksi::whereDoesntHave('pembayaran')
                ->count(),
                
            'pembayaran_berhasil' => Pembayaran::hariIni()->lunas()->count(),
                
            'transaksi_terbaru' => Transaksi::with(['pendaftaran.pasien', 'pembayaran'])
                ->whereDate('created_at', today())
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
                
            'pembayaran_terbaru' => Pembayaran::with(['transaksi.pendaftaran.pasien', 'Pegawai'])
                ->hariIni()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        ];

        return view('kasir.dashboard', $data);
    }

    public function tagihan()
    {
        

        $tagihan = Transaksi::with(['pendaftaran.pasien', 'tindakan', 'obat'])
            ->whereDoesntHave('pembayaran')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kasir.tagihan', compact('tagihan'));
    }

    public function showPembayaran($id_transaksi)
    {
        

        $transaksi = Transaksi::with(['pendaftaran.pasien', 'tindakan', 'obat'])
            ->findOrFail($id_transaksi);

        return view('kasir.pembayaran', compact('transaksi'));
    }

    public function prosesPembayaran(Request $request, $id_transaksi)
    {
        

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,debit,kredit',
            'no_referensi' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id_transaksi);
            $jumlah_bayar = $request->jumlah_bayar;
            $total_tagihan = $transaksi->total_biaya;

            if ($jumlah_bayar < $total_tagihan) {
                throw new \Exception('Jumlah pembayaran kurang dari total tagihan');
            }

            $kembalian = $jumlah_bayar - $total_tagihan;

            $pembayaran = Pembayaran::create([
                'id_transaksi' => $id_transaksi,
                'total_tagihan' => $total_tagihan,
                'jumlah_bayar' => $jumlah_bayar,
                'kembalian' => $kembalian,
                'status_pembayaran' => 'lunas',
                'metode_pembayaran' => $request->metode_pembayaran,
                'no_referensi' => $request->no_referensi,
                'keterangan' => $request->keterangan,
                'id_pegawai' => Auth::user()->id_pegawai
            ]);

            DB::commit();

            return redirect()->route('kasir.tagihan')
                ->with('success', 'Pembayaran berhasil diproses! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())
                         ->withInput();
        }
    }

    public function riwayat()
	{
	    

	    $query = Pembayaran::with(['transaksi.pendaftaran.pasien', 'pegawai'])
	        ->orderBy('created_at', 'desc');

	    // Filter tanggal
	    if (request('start_date') && request('end_date')) {
	        $query->whereBetween('created_at', [
	            request('start_date') . ' 00:00:00',
	            request('end_date') . ' 23:59:59'
	        ]);
	    }

	    // Filter status
	    if (request('status')) {
	        $query->where('status_pembayaran', request('status'));
	    }

	    // Filter metode pembayaran
	    if (request('metode')) {
	        $query->where('metode_pembayaran', request('metode'));
	    }

	    $riwayat = $query->paginate(20);

	    $transaksiHariIni = Pembayaran::whereDate('created_at', today())->count();

	    return view('kasir.riwayat', compact('riwayat', 'transaksiHariIni'));
	}

    public function printStruk($id_pembayaran)
    {
        

        $pembayaran = Pembayaran::with(['transaksi.pendaftaran.pasien', 'transaksi.tindakan', 'transaksi.obat', 'Pegawai'])
            ->findOrFail($id_pembayaran);

        return view('kasir.struk', compact('pembayaran'));
    }
}
