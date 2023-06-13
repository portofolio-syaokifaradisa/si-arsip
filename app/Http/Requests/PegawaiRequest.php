<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        return [
            'nama' => 'required',
            'nip' => "required|numeric|digits:18|unique:pegawais,nip,$id,id",
            'golongan' => 'required',
            'nama_golongan' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required'
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Mohon Masukkan Nama Lengkap Terlebih Dahulu!',
            'nip.required' => 'Mohon Masukkan NIP Pegawai Terlebih Dahulu!',
            'nip.numeric' => 'NIP Harus Berupa Angka!',
            'nip.digits' => 'NIP Harus Terdiri Dari 18 Digit!',
            'nip.unique' => 'NIP Sudah Pernah Terdata!',
            'golongan.required' => 'Mohon Masukkan Golongan Pegawai Terlebih Dahulu!',
            'nama_golongan.required' => 'Mohon Masukkan Nama Golongan Pegawai Terlebih Dahulu!',
            'jabatan.required' => 'Mohon Masukkan Jabatan Pegawai Terlebih Dahulu!',
            'unit_kerja.required' => 'Mohon Masukkan Unit Kerja Terlebih Dahulu!'
        ];
    }
}
