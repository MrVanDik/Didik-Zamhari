<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pasien extends Model
{
    

    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_pasien',
        'no_rm',
        'nama_pasien', 
        'tgl_lahir', 
        'jk', 
        'alamat',
        'no_telp',
        'id_wilayah'
    ];

    protected $casts = [
        'tgl_lahir' => 'date:Y-m-d',
        'id_pasien' => 'string',
        'id_wilayah' => 'integer',
    ];

    protected $appends = ['usia', 'jk_full'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function getUsiaAttribute()
    {
        return $this->tgl_lahir ? Carbon::parse($this->tgl_lahir)->age : null;
    }

    
}