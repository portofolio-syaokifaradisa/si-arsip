<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'desa_id',
        'nama',
        'jabatan',
        'kontak'
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
