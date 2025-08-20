<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['id_daftar', 'id_pegawai', 'diagnosa', 'total_biaya'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_daftar');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function tindakan()
    {
        return $this->belongsToMany(Tindakan::class, 'transaksi_tindakan', 'id_transaksi', 'id_tindakan')
                    ->withPivot('biaya')
                    ->withTimestamps();
    }

    public function obat()
    {
        return $this->belongsToMany(Obat::class, 'tindakan_obat', 'id_transaksi', 'id_obat')
                    ->withPivot('jumlah', 'subtotal')
                    ->withTimestamps();
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi');
    }
}