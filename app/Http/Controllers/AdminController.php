<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Instructors;
use App\Models\Staff;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
        return view('login');
    }
    public function login(){
        return view('login');
    }
    public function register(){
        return view('register');
    }
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function trainer(){
        return view('admin.trainer');
    }
    // Show add-trainer form
    public function addTrainer() {
        return view('admin.add-trainer');
    }

    public function storeTrainer(Request $request)
    {
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'license' => 'required|string|max:50|unique:instructors,LicenseNumber',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trainers', 'public');
        }

        // Store the data in the 'instructors' table
        Instructors::create([
            'Name' => $request->name,
            'LicenseNumber' => $request->license,
            'Phone' => $request->contact,
            'user_id' => Auth::id(), // Get the currently logged-in user ID
            'image' => $imagePath, // Save the image path if uploaded
        ]);

        return redirect()->route('admin.trainer')->with('success', 'Trainer added successfully!');
    }

    public function showUserList(){
        $users = User::whereNull('email_verified_at')->paginate(10);
        return view( 'admin.verify-user', compact('users') );
    }
    public function updateVerify($user_id)
    {
        $user = User::find($user_id);
        $user->update([
            'email_verified_at' => now(),
        ]);
        return redirect()->route('admin.user-verify.index')->with('success', 'User Verified successfully');
    }


    /**WOrking */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);        
        // it is for role admin only
        if( is_null( $admin->AdminRole ) ){
            $request->validate([
                'Name'        => 'required|string|max:255',
                'Address'     => 'nullable|string|max:255',
                'DateOfBirth' => 'nullable|date|max:255',
                'Gender'      => 'nullable|string|max:10',
                'Phone'       => 'nullable|string|regex:/^[0-9]{10,15}$/',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);        
        }
        if( $admin->AdminRole == 'superadmin' ){
            $request->validate([
                'Name'           => 'required|string|max:255',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }
        // Update user table (name only, as email and role should not be updated)
        $user = User::find($admin->user_id);
        $user->update([
            'name' => $request->Name,
        ]);
        // it is for role admin only
        if( is_null( $admin->AdminRole ) ){
            $staff = Staff::where('AdminID', $admin->AdminID)->first();
            $staff->update([
                'Name'        => $request->Name,
                'Address'     => $request->Address,
                'DateOfBirth' => $request->DateOfBirth,
                'Phone'       => $request->Phone,
                'Gender'      => $request->Gender,
            ]);        
        }
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('admins', 'public');
            // Delete old image if needed (optional)
            if ($admin->image) {
                Storage::delete('public/' . $admin->image);
            }
        } else {
            $imagePath = $admin->image; // retain the old image
        }
        Session::put('staff_image_url', $imagePath);
        $user = Auth::user();

        if( $user->role == 'superadmin' || $user->role == 'admin' ){
            return redirect()->route('profile.index')->with('success', 'You Profile updated successfully');
        }
    }

    function destroyUser(Request $request, $id ){
        // Find the staff, if not found, return with an error
        if( $request->role == 'student' ){
            $student = Students::where('user_id', $id)->first();
            if( !$student ){
                return redirect()->route('admin.student.index')->withErrors('Student not found.');
            }            
            $student->delete();// Delete the student$student
            User::find($id)?->delete(); // Manually delete the associated user
            return redirect()->route('admin.user-verify.index')->with('success', 'You have removed student: ' . $student->Name);
        }elseif( $request->role == 'admin'){
            $admin = Admin::where('user_id', $id)->first();
            if( !$admin ){
                return redirect()->route('admin.staff.index')->withErrors('Admin not found.');
            }
            $staff = Staff::where('AdminID', $admin->AdminID)->first();
            $staff->delete(); // remove admin from staff table
            $admin->delete(); // remove admin from admin table
            User::find($id)?->delete(); // Manually delete the associated user
            return redirect()->route('admin.user-verify.index')->with('success', 'You have removed Admin: ' . $staff->Name);
        }elseif( $request->role == 'staff'){
            $staff = Staff::where('user_id', $id)->first();
            if( !$staff ){
                return redirect()->route('admin.staff.index')->withErrors('Staff not found.');
            }
            $staff->delete(); // remove staff from staff table
            User::find($id)?->delete(); // Manually delete the associated user
        
            return redirect()->route('admin.user-verify.index')->with('success', 'You have removed Staff: ' . $staff->Name);
        }elseif( $request->role == 'instructor'){
            $instructor = Instructors::where('user_id', $id)->first();
            if( !$instructor ){
                return redirect()->route('admin.instructor.index')->withErrors('Instructor not found.');
            }        
            $instructor->delete();// delect record from isntructor table
            User::find($id)?->delete(); // Manually delete the associated user

            return redirect()->route('admin.user-verify.index')->with('success', 'You have removed Instructor: ' . $instructor->Name);
        }
    }
}
