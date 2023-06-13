<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'desa_id',
        'tahun',
        'nik',
        'nama',
        'tanggal_lahir',
        'mekanisme_pembayaran',
        'rt',
        'rw',
        'jumlah',
        'tanda_terima'
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
