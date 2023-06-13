<?php

use App\Models\Pegawai;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pegawai::class)->unique()->constrained();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['Admin', 'Superadmin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
