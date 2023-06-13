<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAkunRequest extends FormRequest
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
            'password' => 'nullable',
            'confirmation_password' => 'required_with:password|same:password'
        ];
    }

    public function messages(){
        return [
            'pegawai.required' => 'Mohon Pilih Pegawai Terlebih Dahulu!',
            'email.required' => 'Mohon Masukkan Email Terlebih Dahulu!',
            'email.email' => 'Mohon Masukkan Format Email yang Valid!',
            'email.unique' => 'Email Sudah Pernah Terdaftar!',
            'confirmation_password.required_with' => 'Mohon Masukkan Konfirmasi Password Terlebih Dahulu!',
            'confirmation_password.same' => 'Konfirmasi Password Tidak Sama Dengan Password!'
        ];
    }
}
