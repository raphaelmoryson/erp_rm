<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view("Base.login");
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect('/')->with('success', '');
        } else {
            return redirect('/login')->with('error', "Votre compte n'existe pas.");
        }
    }
    public function logout()
    {
        auth()->logout();
        $user = Auth::user();
        return redirect("/login");
    }
}
