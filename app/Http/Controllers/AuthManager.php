<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login(){
        return view('login');
    }
    
    function registration(){
        return view('registration');
    }


    function loginPost(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended('produk')->with('success', 'Berhasil Login!');
        }
        return redirect(route('login'))->with("error", "Email atau Password yang Anda Masukan Salah!!");
    }


    function registrationPost(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        
        $data['name']= $request->name;
        $data['email']= $request->email;
        $data['password']= Hash::make($request->password);
        $user = User::create($data);
        if(!$user){
            return redirect(route('registration'))->with("error", "Email Sudah Pernah Digunakan");
        }
        return redirect(route('login'))->with("success", "Berhasil Membuat Akun");
    }


    function logout(){
        Session::flush();
        auth::logout();
        return redirect(route('login'))->with('success', 'Anda telah logout.');
    }
}
