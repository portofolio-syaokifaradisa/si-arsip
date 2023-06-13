<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function verify(LoginRequest $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return redirect(route('home'));
        }else{
            return redirect(route('login'))->with('error', 'Email atau Password Salah, Silahkan Coba Lagi!');
        }
    }
}
