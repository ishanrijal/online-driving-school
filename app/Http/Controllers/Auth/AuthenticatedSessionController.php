<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            } elseif ($user->role === 'student') {
                return redirect()->intended(route('student.dashboard', absolute: false));
            } elseif ($user->role === 'instructor') {
                return redirect()->intended(route('instructor.dashboard', absolute: false));
            } elseif ($user->role === 'staff') {
                return redirect()->intended(route('staff.dashboard', absolute: false));
            } else {
                return redirect('/login')->with('error', 'Opps! Something went wrong.');
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
