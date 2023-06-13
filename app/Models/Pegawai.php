<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'unit_kerja',
        'golongan',
        'nama_golongan'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
