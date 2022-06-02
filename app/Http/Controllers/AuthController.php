<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        $check = \App\User::where('username', $request["username"])->first();
        if (!$check) {
            return redirect()->back()->with('error', 'Username tidak tersedia. Mohon coba kembali');
        }
        if (!(Hash::check($request["password"], $check->password))) {
            return redirect()->back()->with("error", "Password anda salah. Mohon coba kembali.");
        }
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->except(['_token']);
        Auth::attempt($credentials);
        if (Auth::check()) {
            $user = \App\User::where('username', $request["username"])->first();
            if ($user) {
                return redirect(route('dashboard'));
            } else {
                return redirect()->back()->with('error', 'Username tidak tersedia');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login password dan username tidak valid ');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
