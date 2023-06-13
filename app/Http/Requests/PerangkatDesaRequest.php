<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerangkatDesaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'desa' => 'required',
            'jabatan' => 'required',
            'nama' => 'required',
            'kontak' => 'required'
        ];
    }

    public function messages(){
        return [
            'desa.required' => 'Mohon Pilih Desa Terlebih Dahulu!',
            'jabatan.required' => 'Mohon Pilih Jabatan Terlebih Dahulu!',
            'nama.required' => 'Mohon Masukkan Nama Lengkap Terlebih Dahulu!',
            'kontak.required' => 'Mohon Masukkan Kontak Terlebih Dahulu!'
        ];
    }
}
