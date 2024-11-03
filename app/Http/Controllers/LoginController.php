<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   function index(){
        return view('pages.auth.login');
   }

   function login(Request $request){
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $data = [
        'email' => $request->email,
        'password' => $request->password
    ];

    if(Auth::attempt($data)){
        return redirect()->route('obat.tampil');
    } else {
        return redirect()->route('login')
        ->with('failed', 'Username atau password salah');
    }
    

   }

   public function logout(){
    Auth::logout();
    return redirect()->route('login');
   }
}
