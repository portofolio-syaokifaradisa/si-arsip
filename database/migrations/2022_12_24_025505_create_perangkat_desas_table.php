<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerangkatDesasTable extends Migration
{
    public function up()
    {
        Schema::create('perangkat_desas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Desa::class)->constrained();
            $table->string('nama');
            $table->enum('jabatan', [
                'Sekretaris Desa',
                'Kaur Umum',
                'Kaur Perencanaan Keuangan',
                'Kasi Pemerintahan',
                'Kasi Pelayanan dan Kesejahteraan'
            ]);
            $table->string('kontak');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_desas');
    }
}
