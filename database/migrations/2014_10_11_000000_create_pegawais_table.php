<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip');
            $table->string('jabatan');
            $table->string('golongan');
            $table->string('nama_golongan');
            $table->string('unit_kerja');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
