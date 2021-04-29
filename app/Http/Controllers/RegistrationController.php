<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); //bcrypt
        $user->save();

        Auth::login($user);
        return redirect()->route('profile.index');
    }
}
