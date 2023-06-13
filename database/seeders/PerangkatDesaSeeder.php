<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Seeder;

class PerangkatDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PerangkatDesa::create([
            'desa_id' => 1,
            'nama' => "Asdasd",
            'jabatan' => "Sekretaris Desa",
            'kontak' => "12133"
        ]);
    }
}
