<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transactions;
    protected $startDate;
    protected $endDate;

    public function __construct($transactions, $startDate, $endDate)
    {
        $this->transactions = $transactions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'LAPORAN TRANSAKSI',
            ["Periode: {$this->startDate} - {$this->endDate}"],
            [],
            [
                'No',
                'Tanggal Transaksi',
                'No. Invoice',
                'Customer',
                'Kasir',
                'Total Amount',
                'Status',
                'Metode Pembayaran'
            ]
        ];
    }

    public function map($transaction): array
    {
        static $i = 1;
        return [
            $i++,
            $transaction->transaction_date,
            $transaction->invoice_number,
            $transaction->customer->name ?? 'Guest',
            $transaction->user->name,
            number_format($transaction->total_amount, 2),
            $transaction->status,
            $transaction->payment_method
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
        ];
    }
}