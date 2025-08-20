<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Transaksi;
use App\Models\Pegawai;
use App\Models\Tindakan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik
       $total_pasien = Pasien::count();
	    $kunjungan_hari_ini = Pendaftaran::whereDate('created_at', today())->count();
	    $resep_baru = Transaksi::whereDate('created_at', today())->count();
	    
	    // Pendapatan bulan ini
	    $pendapatan_bulan_ini = Transaksi::whereMonth('created_at', now()->month)
	        ->whereYear('created_at', now()->year)
	        ->sum('total_biaya');
	    
	    // Growth calculation
	    $growth_pasien = rand(5, 15);
	    $growth_kunjungan = rand(3, 10);
	    $growth_resep = rand(-5, 10);
	    $growth_pendapatan = rand(8, 20);
	    
	    
	    
	    // Chart data - kunjungan 7 hari terakhir
	    $chart_kunjungan = [
	        'labels' => [],
	        'data' => []
	    ];
	    
	    for ($i = 6; $i >= 0; $i--) {
	        $date = Carbon::now()->subDays($i);
	        $chart_kunjungan['labels'][] = $date->format('D');
	        $chart_kunjungan['data'][] = Pendaftaran::whereDate('created_at', $date)->count();
	    }
	    
	    // Chart data - distribusi layanan
	    $chart_layanan = [
	        'labels' => ['Konsultasi', 'Pemeriksaan', 'Pengobatan', 'Tindakan', 'Lainnya'],
	        'data' => [45, 25, 15, 10, 5]
	    ];
	    
	    // FITUR LAPORAN BARU ===========================================
	    
	    // 1. Jumlah kunjungan pasien per bulan (6 bulan terakhir)
	    $kunjungan_per_bulan = [];
	    $bulan_labels = [];
	    
	    for ($i = 5; $i >= 0; $i--) {
	        $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
	        $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
	        
	        $bulan_labels[] = $startOfMonth->format('M Y');
	        $kunjungan_per_bulan[] = Pendaftaran::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
	    }
	    
	    // 2. Jenis tindakan terbanyak (top 5)
	    $tindakan_terbanyak = DB::table('transaksi_tindakan')
		    ->join('tindakan', 'transaksi_tindakan.id_tindakan', '=', 'tindakan.id_tindakan')
		    ->select('tindakan.nama_tindakan', DB::raw('COUNT(transaksi_tindakan.id_tindakan) as total'))
		    ->groupBy('tindakan.nama_tindakan')
		    ->orderByDesc('total')
		    ->limit(5)
		    ->get();							

	    $chart_tindakan = [
	        'labels' => $tindakan_terbanyak->pluck('nama_tindakan')->toArray(),
	        'data' => $tindakan_terbanyak->pluck('total')->toArray()
	    ];
	    
	    // 3. Obat yang paling sering diresepkan (top 5)
	    $obat_terbanyak = DB::table('tindakan_obat')
		    ->join('obat', 'tindakan_obat.id_obat', '=', 'obat.id_obat')
		    ->select('obat.nama_obat', DB::raw('SUM(tindakan_obat.jumlah) as total_resep'))
		    ->groupBy('obat.nama_obat')
		    ->orderByDesc('total_resep')
		    ->limit(5)
		    ->get();

	    
	    $chart_obat = [
	        'labels' => $obat_terbanyak->pluck('nama_obat')->toArray(),
	        'data' => $obat_terbanyak->pluck('total_resep')->toArray()
	    ];
	    
	    // 4. Pendapatan per bulan (6 bulan terakhir)
	    $pendapatan_per_bulan = [];
	    
	    for ($i = 5; $i >= 0; $i--) {
	        $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
	        $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
	        
	        $pendapatan_per_bulan[] = Transaksi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
	            ->sum('total_biaya');
	    }
	    
	    // Aktivitas terbaru
	    $aktivitas_terbaru = [
	        (object)[
	            'judul' => 'Pendaftaran Pasien Baru',
	            'deskripsi' => 'Budi Santoso terdaftar sebagai pasien baru',
	            'waktu' => '10 menit lalu'
	        ],
	        (object)[
	            'judul' => 'Pembayaran Diterima',
	            'deskripsi' => 'Pembayaran dari Siti Rahayu sebesar Rp 350,000',
	            'waktu' => '1 jam lalu'
	        ]
	    ];
	    
	    // END FITUR LAPORAN ===========================================
	    
	    return view('admin.dashboard', compact(
	        'total_pasien',
	        'kunjungan_hari_ini',
	        'resep_baru',
	        'pendapatan_bulan_ini',
	        'growth_pasien',
	        'growth_kunjungan',
	        'growth_resep',
	        'growth_pendapatan',
	        'total_dokter',
	        'total_perawat',
	        'total_apoteker',
	        'chart_kunjungan',
	        'chart_layanan',
	        'aktivitas_terbaru',
	        // Data laporan baru
	        'bulan_labels',
	        'kunjungan_per_bulan',
	        'chart_tindakan',
	        'chart_obat',
	        'pendapatan_per_bulan'
	    ));
	}

}
