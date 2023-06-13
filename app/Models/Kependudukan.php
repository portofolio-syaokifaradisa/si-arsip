<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kependudukan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'desa_id',
        'luas_wilayah',
        'jumlah_lk',
        'tahun',
        'jumlah_perempuan',
        'jumlah',
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
