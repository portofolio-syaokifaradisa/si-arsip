<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanDesaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'desa' => 'required',
            'kegiatan' => 'required',
            'pagu' => 'required',
            'tahun' => 'required|digits:4|numeric'
        ];
    }

    public function messages(){
        return [
            'desa.required' => 'Mohon Pilih Desa Terlebih Dahulu!',
            'kegiatan.required' => 'Mohon Isikan Nama Kegiatan Desa Terlebih Dahulu!',
            'pagu.required' => 'Mohon Isikan Pagu kegiatan Terlebih Dahulu!',
            'tahun.required' => 'Mohon Isikan Tahun Kegiatan Terlebih Dahulu!',
            'tahun.digits' => 'Tahun Kegiatan Harus Terdiri Dari 4 Digit!',
            'tahun.numeric' => 'Tahun Kegiatan Harus Berupa Angka!',
        ];
    }
}
