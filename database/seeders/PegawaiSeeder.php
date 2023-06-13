<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai = [
            [
                'nama' => "Superadmin",
                'nip' => 'Superadmin',
                'jabatan' => 'Superadmin',
                'golongan' => 'Superadmin',
                'nama_golongan' => 'Superadmin',
                'unit_kerja' => 'Superadmin'
            ],
            [
                'nama' => "Admin",
                'nip' => '11111111111111111',
                'jabatan' => '1',
                'golongan' => '1',
                'nama_golongan' => '1',
                'unit_kerja' => '1'
            ],
            [
                'nama' => "H. Syamsuri, SSTP, M.Si",
                'nip' => '198101112000121002',
                'jabatan' => 'camat',
                'golongan' => 'IV/a',
                'nama_golongan' => 'Pembina',
                'unit_kerja' => 'a'
            ],[
                'nama' => "Deasy Mulyanti, SE",
                'nip' => '197912152009012002',
                'jabatan' => 'Sekcam',
                'golongan' => 'III/d',
                'nama_golongan' => 'Penata TK.1',
                'unit_kerja' => 'a'
            ],[
                'nama' => "H. Suleman",
                'nip' => '196508121986031028',
                'jabatan' => 'Kasi Trantib',
                'golongan' => 'III/d',
                'nama_golongan' => 'Penata TK.1',
                'unit_kerja' => 'a'
            ],
        ];

        foreach($pegawai as $data){
            Pegawai::create($data);
        }

        User::create([
            'pegawai_id' => 1,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt("123"),
            'role' => 'Superadmin'
        ]);

        User::create([
            'pegawai_id' => 2,
            'email' => 'admin@gmail.com',
            'password' => bcrypt("123"),
            'role' => 'Admin'
        ]);
    }
}
