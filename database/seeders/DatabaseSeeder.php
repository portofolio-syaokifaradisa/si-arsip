<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PegawaiSeeder::class,
            DesaSeeder::class,
            PerangkatDesaSeeder::class
        ]);
    }
}
