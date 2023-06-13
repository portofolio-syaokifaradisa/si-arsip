<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesasTable extends Migration
{
    public function up()
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('nama_desa');
            $table->string('alamat');
            $table->string('kepala_desa');
            $table->string('kontak_kepala_desa');
            $table->enum('tipe', [
                'Desa',
                'Kelurahan'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('desas');
    }
}
