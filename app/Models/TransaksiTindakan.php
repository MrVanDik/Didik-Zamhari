<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiTindakan extends Model
{
    protected $table = 'transaksi_tindakan';
    protected $fillable = [
        'id_transaksi',
        'id_tindakan',
        'biaya'
    ];
}
