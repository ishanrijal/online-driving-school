<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableScheduler extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if( $user->role ){

            switch ($user->role) {
                case 'admin':
                    return view( 'admin.time-table' );
                case 'student':
                    return view( 'student.time-table' );
                default:
                    return view('profile.default', ['user' => $user]);
            }
        }
    }
}
