<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $data = [
            'total_pasien' => Pasien::count(),
            'pasien_baru_hari_ini' => Pasien::whereDate('created_at', $today)->count(),
            'total_pendaftaran' => Pendaftaran::count(),
            'pendaftaran_hari_ini' => Pendaftaran::whereDate('tgl_daftar', $today)->count(),
            'pendaftaran_antri' => Pendaftaran::where('status', 'antri')->count(),
            'pendaftaran_proses' => Pendaftaran::where('status', 'proses')->count(),
            'pendaftaran_terakhir' => Pendaftaran::with('pasien')
                ->latest()
                ->take(5)
                ->get(),
            'pasien_baru' => Pasien::latest()
                ->take(5)
                ->get()
        ];

        return view('pendaftaran.dashboard', $data);
    }
}