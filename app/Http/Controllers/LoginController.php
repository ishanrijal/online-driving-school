<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        // Validate the form data
        $validator =  $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user if authentication success
        if ( Auth::attempt( $credentials ) ) {
            return redirect()->intended('/admin/dashboard')->with('success', 'You are now logged in.');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        
        // Authentication failed...
        return redirect('login')->withError($validator);
    }

     /**
     * Log the user out of the application.
     *
     */
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
