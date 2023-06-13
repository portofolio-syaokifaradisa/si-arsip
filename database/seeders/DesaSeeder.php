<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $desa = [
            [
                'kode' => '63.06.05.1001',
                'kabupaten' => '',
                'kecamatan' => '',
                'nama_desa' => 'Kandangan Kota',
                'alamat' => '',
                'kepala_desa' => 'M. Meiriza Alamsyah, S.AP',
                'kontak_kepala_desa' => '081258556335'
            ],[
                'kode' => '63.06.05.1002',
                'kabupaten' => '',
                'kecamatan' => '',
                'nama_desa' => 'Kandangan Utara',
                'alamat' => '',
                'kepala_desa' => 'Agus Fitriyadi, S.IP',
                'kontak_kepala_desa' => '08115135555'
            ],[
                'kode' => '63.06.05.1003',
                'kabupaten' => '',
                'kecamatan' => '',
                'nama_desa' => 'Kandangan Barat',
                'alamat' => '',
                'kepala_desa' => 'Ari Nugraha, S. IP',
                'kontak_kepala_desa' => '081349769966'
            ]
        ];

        foreach($desa as $data){
            Desa::create($data);
        }
    }
}
