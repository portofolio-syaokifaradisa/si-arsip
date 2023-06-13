<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanFisiksTable extends Migration
{
    public function up()
    {
        Schema::create('kegiatan_fisiks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Desa::class)->constrained();
            $table->string('kegiatan');
            $table->string('pagu');
            $table->string('realisasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->year('tahun');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan_fisiks');
    }
}
