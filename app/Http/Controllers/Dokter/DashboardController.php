<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Transaksi;
use App\Models\TransaksiTindakan;
use App\Models\TransaksiObat;
use App\Models\Pegawai;
use App\Models\Tindakan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
	{
	    $data = [
	        'total_pasien_hari_ini' => Pendaftaran::whereDate('tgl_daftar', today())->count(),
	        'total_pasien_bulan_ini' => Pendaftaran::whereMonth('tgl_daftar', now()->month)
	            ->whereYear('tgl_daftar', now()->year)
	            ->count(),
	        'antrian_menunggu' => Pendaftaran::whereDate('tgl_daftar', today())
	            ->where('status', 'antri')
	            ->count(),
	        'pendapatan_bulan_ini' => 0,
	        'antrian_terbaru' => Pendaftaran::with(['pasien', 'tindakan'])
	            ->whereDate('tgl_daftar', today())
	            ->orderBy('tgl_daftar', 'desc')
	            ->limit(5)
	            ->get(),
	        'aktivitas_terbaru' => Pendaftaran::with(['pasien', 'tindakan']) 
	            ->where('status', 'selesai')
	            ->whereNotNull('diagnosa')
	            ->orderBy('tgl_daftar', 'desc')
	            ->limit(5)
	            ->get(),
	        'grafik_kunjungan' => $this->getGrafikKunjungan()
	    ];

	    return view('dokter.dashboard', $data);
	}

    private function getGrafikKunjungan()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            
            $count = Pendaftaran::whereDate('tgl_daftar', $date)->count();
            $data[] = $count;
        }

        return compact('labels', 'data');
    }

    public function antrian()
    {
        

        $antrian = Pendaftaran::with('pasien')
            ->whereDate('tgl_daftar', today())
            ->where('status', 'antri')
            ->orderBy('tgl_daftar', 'asc')
            ->get();

        return view('dokter.antrian', compact('antrian'));
    }

    public function viewPasien($id_daftar)
    {
        $pendaftaran = Pendaftaran::with('pasien')->findOrFail($id_daftar);
        
        // Data dummy untuk testing
       $tindakan = Tindakan::orderBy('nama_tindakan')->get();
       $obat = Obat::orderBy('nama_obat')->get();
        
        

        return view('dokter.transaksi', compact('pendaftaran', 'tindakan', 'obat'));
    }

    public function simpanTransaksi(Request $request)
{
    $request->validate([
        'id_daftar' => 'required|exists:pendaftaran,id_daftar',
        'diagnosa' => 'required|string|max:500',

        'tindakan' => 'required|array|min:1',
        'tindakan.*' => 'sometimes|numeric|exists:tindakan,id_tindakan',

        'obat' => 'nullable|array',
        'obat.*' => 'nullable|numeric|exists:obat,id_obat',

        'jumlah_obat' => 'nullable|array',
        'jumlah_obat.*' => 'nullable|integer|min:1',
    ], [
        'tindakan.required' => 'Pilih minimal satu tindakan medis',
        'tindakan.min' => 'Pilih minimal satu tindakan medis',
        'tindakan.*.numeric' => 'Format tindakan tidak valid',
        'tindakan.*.exists' => 'Tindakan tidak ditemukan',
        'obat.*.numeric' => 'Format obat tidak valid',
        'obat.*.exists' => 'Obat tidak ditemukan',
        'jumlah_obat.*.integer' => 'Jumlah obat harus angka',
        'jumlah_obat.*.min' => 'Jumlah obat minimal 1',
    ]);

    if (empty($request->tindakan)) {
        return back()->withErrors(['tindakan' => 'Pilih minimal satu tindakan medis'])->withInput();
    }

    $tindakan_ids = array_map('intval', $request->tindakan ?? []);
    $obat_ids = $request->has('obat') ? array_map('intval', $request->obat) : [];
    $jumlah_obat = $request->has('jumlah_obat') ? array_map('intval', $request->jumlah_obat) : [];

    DB::beginTransaction();
    try {
        $pendaftaran = Pendaftaran::where('id_daftar', $request->id_daftar)->first();
        
        if (!$pendaftaran) {
            throw new \Exception("Data pendaftaran tidak ditemukan");
        }
        
        $pendaftaran->update([
            'diagnosa' => $request->diagnosa,
            'status' => 'selesai',
            'updated_at' => now()
        ]);
        
        $transaksi = Transaksi::create([
            'id_daftar' => $request->id_daftar,
            'id_pegawai' => Auth::user()->id_pegawai,
            'diagnosa' => $request->diagnosa,
            'total_biaya' => 0
        ]);

        $total_biaya = 0;

        foreach ($tindakan_ids as $tindakan_id) {
            $tindakan = Tindakan::find($tindakan_id);


            
            if ($tindakan) {
                TransaksiTindakan::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_tindakan' => $tindakan_id, 
                    'nama_tindakan' => $tindakan->nama_tindakan,
                    'biaya' => $tindakan->biaya_tindakan 
                ]);
                
                $total_biaya += $tindakan->biaya_tindakan; 
            }
        }

        if (!empty($obat_ids)) {
            foreach ($obat_ids as $index => $obat_id) {
                $obat = Obat::find($obat_id);
                
                if ($obat) {
                    $jumlah = $jumlah_obat[$index] ?? 1;
                    
                    // Validasi stok
                    if ($obat->stok < $jumlah) {
                        throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Stok tersedia: {$obat->stok}");
                    }
                    
                    $subtotal = $obat->harga_obat * $jumlah; 
                    
    
                    TransaksiObat::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_obat' => $obat_id, 
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal
                    ]);
                    
                    // Kurangi stok obat
                    $obat->decrement('stok', $jumlah);
                    
                    $total_biaya += $subtotal;
                }
            }
        }

        $transaksi->update(['total_biaya' => $total_biaya]);

        DB::commit();

        return redirect()->route('dokter.antrian')
            ->with('success', 'Transaksi berhasil disimpan! Total biaya: Rp ' . number_format($total_biaya, 0, ',', '.'));

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Error simpan transaksi: ' . $e->getMessage());
        
        return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())
                     ->withInput();
    }
}

    private function getBiayaTindakan($tindakan_id)
    {
        $biaya = [
            1 => 50000, // Konsultasi
            2 => 75000, // Pemeriksaan Darah
            3 => 60000, // Suntik Vitamin
        ];
        
        return $biaya[$tindakan_id] ?? 0;
    }

    private function getBiayaObat($obat_id)
    {
        $harga = [
            1 => 5000,  // Paracetamol
            2 => 7500,  // Amoxicillin
            3 => 3000,  // Vitamin C
        ];
        
        return $harga[$obat_id] ?? 0;
    }
}
