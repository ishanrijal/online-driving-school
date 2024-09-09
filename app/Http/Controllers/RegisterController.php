<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Store
    public function store( Request $request ){
        $request->validate([
            'username'              => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'role'                  => 'required|string|in:admin,student,staff,instructor',
            'password'              => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|min:8',
        ]);

        User::create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'role'     => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    }
}
