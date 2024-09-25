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
        dd("I am here");
        // Validate the form data
        $validator =  $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user if authentication is successful
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user
            // Check the user's role and redirect accordingly
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'You are now logged in as admin.');
            } elseif ($user->role === 'student') {
                return redirect()->intended('/student/dashboard')->with('success', 'You are now logged in as student.');
            } elseif ($user->role === 'instructor') {
                return redirect()->intended('/instructor/dashboard')->with('success', 'You are now logged in as instructor.');
            } else {
                // Handle other roles or default behavior
                return redirect('/login')->with('error', 'Role not recognized.');
            }
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
