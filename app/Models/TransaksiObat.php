<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiObat extends Model
{
    protected $table = 'tindakan_obat';
    protected $fillable = [
        'id_transaksi', 
        'id_obat', 
        'jumlah', 
        'subtotal'
    ];

    public $timestamps = true;

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}