<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBltsTable extends Migration
{
    public function up()
    {
        Schema::create('blts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Desa::class)->constrained();
            $table->integer('tahun');
            $table->string('nik');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('mekanisme_pembayaran');
            $table->integer('rt');
            $table->integer('rw');
            $table->string('jumlah');
            $table->string('tanda_terima');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blts');
    }
}
