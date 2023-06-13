<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKependudukansTable extends Migration
{
    public function up()
    {
        Schema::create('kependudukans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Desa::class)->constrained();
            $table->string('luas_wilayah');
            $table->integer('jumlah_lk');
            $table->integer('jumlah_perempuan');
            $table->integer('tahun');
            $table->integer('jumlah');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kependudukans');
    }
}
