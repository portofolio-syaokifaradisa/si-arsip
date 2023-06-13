<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode' => "required|unique:desas,kode,$this->id,id",
            'nama_desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'alamat' => 'required',
            'kepala_desa' => 'required',
            'kontak_kepala_desa' => 'required',
            'tipe' => 'required'
        ];
    }

    public function messages(){
        return [
            'kode.required' => 'Mohon Masukkan Kode Desa/Kelurahan Terlebih Dahulu!',
            'kode.unique' => 'Kode Desa/Kelurahan Sudah Pernah Terdata!',
            'nama_desa.required' => 'Mohon Masukkan Nama Desa/Kelurahan Terlebih Dahulu!',
            'kecamatan.required' => 'Mohon Masukkan Kecamatan Desa/Kelurahan Terlebih Dahulu!',
            'kabupaten.required' => 'Mohon Masukkan Kabupaten Desa/Kelurahan Terlebih Dahulu!',
            'alamat.required' => 'Mohon Masukkan Alamat Kantor Desa/Kelurahan Terlebih Dahulu!',
            'kepala_desa.required' => 'Mohon Masukkan Nama Lengkap Kepala Desa/Kelurahan Terlebih Dahulu!',
            'kontak_kepala_desa.required' => "Mohon Masukkan Kontak Kepala Desa/Kelurahan terlebih Dahulu!",
            'tipe.required' => 'Mohon Masukkan Tipe terlebih Dahulu!'
        ];
    }
}
