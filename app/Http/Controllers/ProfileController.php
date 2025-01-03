<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Instructor;
use App\Http\Middleware\Student;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\ClassSchedules;
use App\Models\Courses;
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
                $user = Auth::user();
                $data['staff'] = Staff::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
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
                $data['invoices'] = Invoices::where('status', 'paid')->take(5)->get();
                $data['courses'] = Courses::take(5)->get();

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
                $data['staff_count'] = Staff::count();

                $data['total_invoice'] = Invoices::where('status', 'paid')->sum('TotalAmount'); 
                Session::put('total_invoice', $data['total_invoice'] );

                Session::put('students_count', $data['students_count'] );
                Session::put('instructors_count', $data['instructors_count'] );
                Session::put('staff_count', $data['staff_count'] );
                
                return view('admin.dashboard', compact('data'));
            case 'admin':
                $data['invoices'] = Invoices::where('status', 'paid')->take(5)->get();
                $data['courses'] = Courses::take(5)->get();

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
                    $data['staff_count'] = Staff::count();

                    $data['total_invoice'] = Invoices::where('status', 'paid')->sum('TotalAmount'); 
                    Session::put('total_invoice', $data['total_invoice'] );
    
                    Session::put('students_count', $data['students_count'] );
                    Session::put('instructors_count', $data['instructors_count'] );
                    Session::put('staff_count', $data['staff_count'] );
                    
                    return view('admin.dashboard', compact('data'));
                }
                return view('profile.default', ['user' => $user]);
    
            case 'staff':
                $data['invoices'] = Invoices::where('status', 'paid')->take(5)->get();
                $data['users'] = User::whereIn('role', ['instructor', 'student'])
                     ->latest()->take(5)->get();
                // Fetch staff-specific data if needed
                $data['staff'] = Staff::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
                if( $data['staff']->image ){
                    $imageUrl = asset('storage/' . $data['staff']->image);
                }else{
                    $imageUrl='';
                }
                Session::put('staff_image_url', $imageUrl);

                $data['students_count'] = Students::count();
                $data['instructors_count'] = Instructors::count();
                $data['courses_count'] = Courses::count();

                Session::put('students_count', $data['students_count'] );
                Session::put('instructors_count', $data['instructors_count'] );
                Session::put('courses_count', $data['courses_count'] );
                

                $data['invoices_paid'] = Invoices::where('status', 'paid')->count();
                $data['invoices_unpaid'] = Invoices::where('status', 'unpaid')->count();
                $data['invoices_processing'] = Invoices::where('status', 'processing')->count();

                Session::put('invoices_paid', $data['invoices_paid'] );
                Session::put('invoices_unpaid', $data['invoices_unpaid'] );
                Session::put('invoices_processing', $data['invoices_processing'] );
                
                return view( 'staff.dashboard', compact('data') );
    
            case 'student':
                // Fetch student-specific data if needed
                $data['student'] = Students::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;

                $appointments = ClassSchedules::where('StudentID', $data['student']->StudentID)->get();
                $today_appointments = ClassSchedules::where('StudentID', $data['student']->StudentID)->where('class_status', 'confirmed')->whereDate('Date', DB::raw('CURDATE()'))->with( ['instructor.user', 'course'])->get();

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
                $appointment_pending = ClassSchedules::where('class_status', 'pending')->where('InstructorID', $data['instructor']->InstructorID)->get();
                Session::put('appointment_pending_count', $appointment_pending->count() );
                $today_appointments = ClassSchedules::where('InstructorID', $data['instructor']->InstructorID)->whereDate('Date', DB::raw('CURDATE()'))->with( ['student.user', 'course'])->get();
                return view('instructor.dashboard', compact( 'data', 'appointments', 'today_appointments', 'appointment_pending' ));
    
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
            case 'staff':
                $data['data' ]= Staff::where('user_id', $user->user_id)->first();
                $data['user_email'] = $user->email;
            break;
            case 'student':
                $data['data' ]= Students::where('user_id', $user->user_id)->first();
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
