<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginSuccessful = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        if ($loginSuccessful) {
            return redirect()->route('profile.index');
        } else {
            return redirect()->route('auth.loginForm')
                ->with('error', 'Invalid credentials.');
        }
    }

    public function logout()
    {
        Auth::logout();
        //return redirect()->route('invoice.index');
        return view('layouts.main');
    }
}
