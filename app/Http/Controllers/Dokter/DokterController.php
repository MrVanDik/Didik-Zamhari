<?php
namespace App\Http\Controllers\Dokter;

use App\Models\Pendaftaran;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    // Menampilkan antrian pasien hari ini
    public function antrian()
    {
        $antrian = Pendaftaran::with('pasien')
            ->where('id_dokter', Auth::user()->id_pegawai)
            ->whereDate('created_at', today())
            ->where('status', 'antri')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dokter.antrian', compact('antrian'));
    }

    // Menampilkan form transaksi untuk pasien
    public function showTransaksiForm($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::with('pasien')->findOrFail($id_pendaftaran);
        $tindakan = Tindakan::all();
        $obat = Obat::where('stok', '>', 0)->get();

        return view('dokter.transaksi', compact('pendaftaran', 'tindakan', 'obat'));
    }

    // Menyimpan transaksi
    public function simpanTransaksi(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|array',
            'tindakan.*' => 'exists:tindakan,id',
            'obat' => 'nullable|array',
            'obat.*' => 'exists:obat,id',
            'jumlah_obat' => 'nullable|array',
            'jumlah_obat.*' => 'integer|min:1'
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat transaksi baru
            $transaksi = Transaksi::create([
                'id_pendaftaran' => $request->id_pendaftaran,
                'id_dokter' => Auth::user()->id_pegawai,
                'diagnosa' => $request->diagnosa,
                'total_biaya' => 0
            ]);

            $total_biaya = 0;

            // Tambahkan tindakan
            foreach ($request->tindakan as $tindakan_id) {
                $tindakan = Tindakan::find($tindakan_id);
                $transaksi->tindakan()->attach($tindakan_id, ['biaya' => $tindakan->biaya]);
                $total_biaya += $tindakan->biaya;
            }

            // Tambahkan obat jika ada
            if ($request->has('obat')) {
                foreach ($request->obat as $index => $obat_id) {
                    $obat = Obat::find($obat_id);
                    $jumlah = $request->jumlah_obat[$index] ?? 1;
                    
                    // Pastikan stok mencukupi
                    if ($obat->stok < $jumlah) {
                        throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi");
                    }

                    $subtotal = $obat->harga * $jumlah;
                    
                    $transaksi->obat()->attach($obat_id, [
                        'jumlah' => $jumlah,
                        'harga' => $obat->harga,
                        'subtotal' => $subtotal
                    ]);

                    // Kurangi stok obat
                    $obat->decrement('stok', $jumlah);
                    
                    $total_biaya += $subtotal;
                }
            }

            // Update total biaya transaksi
            $transaksi->update(['total_biaya' => $total_biaya]);

            // Update status pendaftaran
            Pendaftaran::find($request->id_pendaftaran)->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->route('dokter.antrian')
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
