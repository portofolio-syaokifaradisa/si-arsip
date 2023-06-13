<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class AkunRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pegawai' => 'required',
            'email' => "required|email|unique:users,email,$this->id,id",
            'password' => 'required',
            'confirmation_password' => 'required|same:password'
        ];
    }

    public function messages(){
        return [
            'pegawai.required' => 'Mohon Pilih Pegawai Terlebih Dahulu!',
            'email.required' => 'Mohon Masukkan Email Terlebih Dahulu!',
            'email.email' => 'Mohon Masukkan Format Email yang Valid!',
            'email.unique' => 'Email Sudah Pernah Terdaftar!',
            'password.required' => 'Mohon Masukkan Password Terlebih Dahulu!',
            'confirmation_password.required' => 'Mohon Masukkan Konfirmasi Password Terlebih Dahulu!',
            'confirmation_password.same' => 'Konfirmasi Password Tidak Sama Dengan Password!'
        ];
    }
}
