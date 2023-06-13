<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'kode',
        'kabupaten',
        'kecamatan',
        'nama_desa',
        'alamat',
        'kepala_desa',
        'kontak_kepala_desa',
        'tipe'
    ];
}
