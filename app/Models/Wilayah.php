<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah'; 
    protected $primaryKey = 'id_wilayah';
    protected $fillable = ['nama_wilayah', 'tipe'];
}
