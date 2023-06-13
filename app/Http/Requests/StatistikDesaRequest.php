<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatistikDesaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'desa' => 'required',
            'tahun' => 'required|digits:4|numeric',
            'wilayah' => 'required',
            'lk' => 'required|numeric',
            'perempuan' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'desa.required' => 'Mohon Pilih Desa Terlebih Dahulu!',
            'tahun.required' => 'Mohon isikan Tahun Pencatatan Terlebih Dahulu!',
            'tahun.digits' => 'Mohon Isikan Form Tahun Pencatatan Sebanyaks 4 Digit!',
            'tahun.numeric' => 'Mohon Isikan Tahun Pencatatan Berupa Angka!',
            'wilayah.required' => 'Mohon Isikan Luas Wilayah Terlebih Dahulu!',
            'lk.required' => 'Mohon isikan Jumlah Laki-laki Terlebih Dahulu!',
            'lk.numeric' => 'Mohon Isikan Jumlah Laki-laki Berupa Angka!',
            'perempuan.required' => 'Mohon Isikan Jumlah Perempuan Terlebih Dahulu!',
            'perempuan.numeric' => 'Mohon Isikan Jumlah Perempuan Berupa Angka!'
        ];
    }
}
