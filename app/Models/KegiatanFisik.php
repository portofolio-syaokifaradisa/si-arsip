<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanFisik extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'desa_id',
        'kegiatan',
        'pagu',
        'realisasi',
        'keterangan',
        'tahun'
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
