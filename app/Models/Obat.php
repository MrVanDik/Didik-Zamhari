<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';          
    protected $primaryKey = 'id_obat';  
    public $incrementing = true;        
    protected $fillable = ['kode_obat', 'nama_obat', 'jenis_obat', 'stok', 'harga_obat', 'expired_date', 'keterangan'];
}
