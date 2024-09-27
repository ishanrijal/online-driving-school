<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Instructor;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\ClassSchedules;
use App\Models\Instructors;
use App\Models\Invoices;
use App\Models\Staff;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();   
        // Fetch data based on the role
        $data = [];
        switch ($user->role) {
            case 'admin':
            case 'superadmin':
                $admin = Admin::where('user_id', $user->user_id)->first();
                if ($admin) {
                    if($user->role == 'superadmin') {
                        $data['staff'] = $admin;
                        $data['user_email'] = $user->email;
                        return view('profile.admin', $data);
                    }else{
                        $data['staff'] = Staff::where('AdminID', $admin->AdminID)->first();
                        $data['user_email'] = $user->email;
                        return view('profile.admin', $data);
                    }
                }    
            break;
            case 'staff':
                // Fetch staff-specific data if needed
                $data['staff'] = Staff::where('AdminID', $user->user_id)->first();
                return view('profile.staff', $data);
    
            case 'student':
                // Fetch student-specific data if needed
                $data['staff'] = Students::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
                return view('profile.student', $data);
    
            case 'instructor':
                // Fetch instructor-specific data if needed
                $data['instructor'] = Instructors::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
                return view('profile.instructor', $data);
    
            default:
                // Handle unknown roles or default case
                return view('profile.default', ['user' => $user]);
        }
    }
    public function showDashboard(Request $request): View
    {
        $user = Auth::user(); // get current user
        $data = [];

        switch ($user->role) {
            case 'superadmin':
                $data['staff'] = User::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
                if( $data['staff']->image ){
                    $imageUrl = asset('storage/' . $data['staff']->image);
                }else{
                    $imageUrl='';
                }
                // Store in session
                Session::put('staff_image_url', $imageUrl);

                $data['students_count'] = Students::count();
                $data['instructors_count'] = Instructors::count();

                Session::put('students_count', $data['students_count'] );
                Session::put('instructors_count', $data['instructors_count'] );
                
                return view('admin.dashboard', $data);
            case 'admin':
                $admin = Admin::where('user_id', $user->user_id)->first();
                if ($admin) {
                    $data['staff'] = Staff::where('AdminID', $admin->AdminID)->first();
                    $data['user_email'] = $user->email;
                    if( $data['staff']->image ){
                        $imageUrl = asset('storage/' . $data['staff']->image);
                    }else{
                        $imageUrl='';
                    }
                    // Store in session
                    Session::put('staff_image_url', $imageUrl);

                    $data['students_count'] = Students::count();
                    $data['instructors_count'] = Instructors::count();

                    Session::put('students_count', $data['students_count'] );
                    Session::put('instructors_count', $data['instructors_count'] );
                    
                    return view('admin.dashboard', $data);
                }
                return view('profile.default', ['user' => $user]);
    
            case 'staff':
                // Fetch staff-specific data if needed
                $data['staff'] = Staff::where('AdminID', $user->user_id)->first();
                return view('profile.staff', $data);
    
            case 'student':
                // Fetch student-specific data if needed
                $data['student'] = Students::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;

                $appointments = ClassSchedules::where('StudentID', $data['student']->StudentID)->get();
                $today_appointments = ClassSchedules::where('StudentID', $data['student']->StudentID)->whereDate('Date', DB::raw('CURDATE()'))->with( ['instructor.user', 'course'])->get();

                $invoices = Invoices::where('StudentID', $data['student']->StudentID)->where('Status', 'unpaid')->get();

                return view('student.dashboard', compact( 'data', 'appointments','invoices', 'today_appointments'));
    
            case 'instructor':
                // Fetch instructor-specific data if needed
                $data['instructor'] = Instructors::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;

                if( $data['instructor']->image ){
                    $imageUrl = asset('storage/' . $data['instructor']->image);
                }else{
                    $imageUrl='';
                }
                // Store in session
                Session::put('staff_image_url', $imageUrl);


                $appointments = ClassSchedules::where('InstructorID', $data['instructor']->InstructorID)->get();
                $today_appointments = ClassSchedules::where('InstructorID', $data['instructor']->InstructorID)->whereDate('Date', DB::raw('CURDATE()'))->with( ['student.user', 'course'])->get();
                return view('instructor.dashboard', compact( 'data', 'appointments', 'today_appointments' ));
    
            default:
                // Handle unknown roles or default case
                return view('profile.default', ['user' => $user]);
        }
    }
    
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // $staff = Staff::findOrFail( $id );
        // return view('admin.edit-staff', compact('staff'));
        $user = Auth::user();    
        $data = [];
        switch ($user->role) {
            case 'admin':
            case 'superadmin':
                $admin = Admin::where('user_id', $user->user_id)->first();
                if( ! ($user->role == 'superadmin') ){
                    $data['data'] = Staff::where('AdminID', $admin->AdminID)->first();
                    $data['user_email'] = $user->email;
                }else{
                    $data['user_email'] = $user->email;
                    $data['data'] = $admin;
                }
            break;
            case 'instructor':
                $data['data' ]= Instructors::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
            break;

            default:
            break;
        }
        return view('profile.edit', $data );
    }
    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {        
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
