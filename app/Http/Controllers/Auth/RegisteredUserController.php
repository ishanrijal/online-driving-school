<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Instructors;
use App\Models\Staff;
use App\Models\Students;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'                  => 'required|string|in:admin,student,staff,instructor',
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();

        try{
            // Create a user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => $request->input('role'),
                'password' => Hash::make($request->password),
            ]);

            if ($user->role === 'admin') {
                $admin = Admin::create([
                    'user_id' => $user->user_id,
                ]);
                Staff::create([
                    'Name'    => $user->name,
                    'AdminID' => $admin->AdminID,
                ]);
            }
            if ($user->role === 'staff') {
                Staff::create([
                    'Name'    => $user->name,
                    'user_id' => $user->user_id,
                    'AdminID' => null,
                ]);
            }
            if ($user->role === 'student') {
                Students::create([
                    'Name'    => $user->name,
                    'user_id' => $user->user_id,
                ]);
                $user->update([
                    'email_verified_at' => now(),
                ]);
            }
            if ($user->role === 'instructor') {
                Instructors::create([
                    'Name'    => $user->name,
                    'user_id' => $user->user_id,
                ]);
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            event(new Registered($user));

            Auth::login($user);
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'instructor':
                    return redirect()->route('instructor.dashboard');
                case 'staff':
                    return redirect()->route('staff.dashboard');
                default:
                    return redirect()->route('home'); // Fallback to home or any default route
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
    
            // Optionally, log the error for further investigation
            logger()->error($e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withErrors(['registration-fail' => 'There was an error creating the user. Please try again.']);
        }
    }
}
