<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Transaksi;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Validasi tanggal
        if ($startDate > $endDate) {
            $startDate = $endDate;
        }

        // Data untuk chart
        $chartData = $this->getChartData($startDate, $endDate);
        
        // Statistik utama
        $stats = $this->getStats($startDate, $endDate);
        
        // Data tabel
        $tableData = $this->getTableData($startDate, $endDate);

        return view('admin.laporan.index', compact(
            'startDate', 
            'endDate', 
            'chartData', 
            'stats',
            'tableData'
        ));
    }

    public function export(Request $request)
	{
	    $request->validate([
	        'start_date' => 'required|date',
	        'end_date' => 'required|date|after_or_equal:start_date',
	        'export_type' => 'required|in:excel,pdf'
	    ]);

	    $startDate = $request->input('start_date');
	    $endDate = $request->input('end_date');
	    $exportType = $request->input('export_type');

	    // Ambil data berdasarkan range tanggal
	    $transactions = Transaction::with(['customer', 'user'])
	        ->whereBetween('transaction_date', [$startDate, $endDate])
	        ->orderBy('transaction_date', 'desc')
	        ->get();

	    if ($transactions->isEmpty()) {
	        return redirect()->back()->with('error', 'Tidak ada data transaksi pada periode yang dipilih.');
	    }

	    // Hitung total untuk summary
	    $totalAmount = $transactions->sum('total_amount');
	    $totalTransactions = $transactions->count();

	    if ($exportType === 'excel') {
	        return Excel::download(new TransactionsExport($transactions, $startDate, $endDate), 
	            "laporan-transaksi-{$startDate}-to-{$endDate}.xlsx");
	    }

	    if ($exportType === 'pdf') {
	        $data = [
	            'transactions' => $transactions,
	            'startDate' => $startDate,
	            'endDate' => $endDate,
	            'totalAmount' => $totalAmount,
	            'totalTransactions' => $totalTransactions
	        ];

	        $pdf = PDF::loadView('exports.transactions-pdf', $data);
	        return $pdf->download("laporan-transaksi-{$startDate}-to-{$endDate}.pdf");
	    }

	    return redirect()->back()->with('error', 'Format export tidak valid.');
	}

    private function getChartData($startDate, $endDate)
    {
        // Data kunjungan per hari
        $kunjunganPerHari = Pendaftaran::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Data pendapatan per hari
        $pendapatanPerHari = Transaksi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_biaya) as total')
            )
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return [
            'labels' => $kunjunganPerHari->pluck('tanggal'),
            'kunjungan' => $kunjunganPerHari->pluck('total'),
            'pendapatan' => $pendapatanPerHari->pluck('total')
        ];
    }

    private function getStats($startDate, $endDate)
    {
        return [
            'total_kunjungan' => Pendaftaran::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count(),
            'total_pendapatan' => Transaksi::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('total_biaya'),
            'total_pasien_baru' => Pasien::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count(),
            'rata_kunjungan' => Pendaftaran::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count() / max(1, Carbon::parse($startDate)->diffInDays($endDate))
        ];
    }

    private function getTableData($startDate, $endDate)
    {
        
        $tindakanTerbanyak = DB::table('transaksi_tindakan as tt')
		    ->join('transaksi as tr', 'tt.id_transaksi', '=', 'tr.id_transaksi')
		    ->join('tindakan as t', 'tt.id_tindakan', '=', 't.id_tindakan')
		    ->select('t.nama_tindakan', DB::raw('COUNT(*) as jumlah'))
		    ->whereBetween('tr.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
		    ->groupBy('t.id_tindakan', 't.nama_tindakan')
		    ->orderBy('jumlah', 'desc')
		    ->limit(10)
		    ->get();


       
        $obatTerbanyak = DB::table('tindakan_obat as to')
		    ->join('transaksi as tr', 'to.id_transaksi', '=', 'tr.id_transaksi')
		    ->join('obat as o', 'to.id_obat', '=', 'o.id_obat')
		    ->select('o.nama_obat', DB::raw('SUM(to.jumlah) as total'))
		    ->whereBetween('tr.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
		    ->groupBy('o.id_obat', 'o.nama_obat')
		    ->orderBy('total', 'desc')
		    ->limit(10)
		    ->get();


        return [
            'tindakan' => $tindakanTerbanyak,
            'obat' => $obatTerbanyak
        ];
    }
}