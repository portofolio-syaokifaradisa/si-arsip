<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BltRequest extends FormRequest
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
            'nama' => 'required',
            'nik' => 'required|numeric|digits:16',
            'ttl' => 'required',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'mekanisme_pembayaran' => 'required',
            'jumlah' => 'required',
            'tanda_terima' => 'required'
        ];
    }

    public function messages(){
        return [
            'desa.required' => 'Mohon Pilih Desa Penerima BLT Terlebih Dahulu!',
            'tahun.required' => 'Mohon Masukkan Periode Tahun BLT!',
            'tahun.digits' => 'Mohon Masukkan 4 Digit!',
            'tahun.numerik' => 'Mohon Masukkan Berupa Angka!',
            'nama.required' => 'Mohon Masukkan Nama Lengkap Penerima BLT!',
            'nik.required' => 'Mohon Masukkan NIK Penerima BLT!',
            'nik.numeric' => 'Mohon Masukkan Berupa Angka!',
            'nik.digits' => 'Mohon Masukkan 16 Digit NIK!',
            'ttl.required' => 'Mohon Pilih Tanggal Lahir Penerima BLT!',
            'rt.required' => 'Mohon Masukkan RT Penerima BLT Terlebih Dahulu!',
            'rt.numeric' => 'Mohon Masukkan Berupa Angka!',
            'rw.required' => 'Mohon Masukkan RW Penerima BLT Terlebih Dahulu!',
            'rw.numeric' => 'Mohon Masukkan Berupa Angka!',
            'mekanisme_pembayaran.required' => 'Mohon Masukkan Mekanisme Pembayaran BLT!',
            'jumlah.required' => 'Mohon Masukkan Jumlah Bantuan yang Diterima!',
            'tanda_terima.required' => 'Mohon Upload Foto Tanda Bukti Tanda Penerimaan!'
        ];
    }
}
