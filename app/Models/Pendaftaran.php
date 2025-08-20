<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_daftar';
    public $timestamps = true;

    protected $fillable = [
        'id_pasien',
        'no_rm',
        'no_reg',
        'tgl_daftar',
        'jenis_kunjungan',
        'status',
        'keluhan',
        'diagnosa',
    ];

    protected $casts = [
        'tgl_daftar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class, 'pendaftaran_id');
    }
    

    public function getStatusLengkapAttribute()
    {
        $statuses = [
            'antri' => 'Menunggu Antrian',
            'proses' => 'Dalam Pemeriksaan',
            'selesai' => 'Selesai'
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getJenisKunjunganLengkapAttribute()
    {
        return $this->jenis_kunjungan == 'baru' ? 'Baru' : 'Lama';
    }


}