<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InstructorController extends Controller
{
    /**
     * Display a listing of trainers.
     */
    public function index()
    {
        $user = Auth::user();
        $instructors = Instructors::with('user')->paginate(10);
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view( 'admin.instructor', compact('instructors') );
        }else{
            return view( 'staff.instructor', compact('instructors') );
        }
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view('admin.add-instructor');
        }else{
            return view('staff.add-instructor');
        }
    }

    /**
     * Store a newly created trainer in the database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'LicenseNumber' => 'nullable|string|unique:instructors,LicenseNumber',
            'contact' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Handle file upload if the image is provided
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('instructors', 'public');
            }
    
            // Create the user
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'role'              => 'instructor',
                'password'          => Hash::make($request->name),   // temporary password
                'email_verified_at' => now(),
            ]);
    
            // Create the instructor
            Instructors::create([
                'Name' => $request->name,
                'LicenseNumber' => $request->LicenseNumber,
                'Phone' => $request->contact,
                'image' => $imagePath,
                'user_id' => $user->user_id,
            ]);
    
            // Commit the transaction
            DB::commit();
            
            if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
                return redirect()->route('admin.instructor.index')->with('success', 'Instructor has been created successfully.');
            }else{
                return redirect()->route('staff.instructor.index')->with('success', 'Instructor has been created successfully.');
            }
    
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
    
            return back()->withErrors(['error' => 'An error occurred while creating the instructor. Please try again.']);
        }
    }
    

    /**
     * Show the form for editing a trainer.
     */
    public function edit($id)
    {
        // Retrieve the instructor based on the provided ID
        $instructor = Instructors::findOrFail($id);
        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view('admin.edit-instructor', compact('instructor'));
        }else{
            return view('staff.edit-instructor', compact('instructor'));
        }
        
    }

    /**
     * Update the specified trainer in the database.
     */
    public function update(Request $request, $id)
    {
        $instructor = Instructors::findOrFail($id);
        $request->validate([
            'name'           => 'required|string|max:255',
            'Address'           => 'string',
            'Gender' => [
                'nullable',
                Rule::in(['male', 'female', 'other']),
            ],
            'Phone'        => 'nullable|regex:/^\+?[0-9]{1,15}$/',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);        
        // Update user table (name only, as email and role should not be updated)
        $user = User::find($instructor->user_id);
        $user->update([
            'name' => $request->name,
        ]);
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('instructors', 'public');
            // Delete old image if needed (optional)
            if ($instructor->image) {
                Storage::delete('public/' . $instructor->image);
            }
        } else {
            $imagePath = $instructor->image; // retain the old image
        }
        $instructor->update([
            'Name'          => $request->name,
            'Phone'         => $request->Phone,
            'Gender'         => $request->Gender,
            'Address'         => $request->Address,
            'image'         => $imagePath,
        ]);

        if( $imagePath ){
            $imageUrl = asset('storage/' . $imagePath);
        }else{
            $imageUrl='';
        }

        Session::put('staff_image_url', $imageUrl);
        $user = Auth::user();
        if( $user->role == 'instructor'){
            return redirect()->route('profile.index')->with('success', 'Your Profile updated successfully');
        }elseif( ( $user->role == 'admin') || ($user->role == 'superadmin') ){
            return redirect()->route('admin.instructor.index')->with('success', 'Instructor updated successfully');
        }elseif( ( $user->role == 'staff') ){
            return redirect()->route('staff.instructor.index')->with('success', 'Instructor updated successfully');
        }
    }
    /**
     * Remove the specified trainer from the database.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        // Find the instructor by ID or fail
        $instructor = Instructors::findOrFail($id);
        $userId = $instructor->user_id;

        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Delete the instructor
            $instructor->delete();
            // Manually delete the associated user
            User::find($userId)?->delete();
    
            // Commit the transaction
            DB::commit();
    
            // Redirect based on the user's role
            if ($user->role == 'admin' || $user->role == 'superadmin') {
                return redirect()->route('admin.instructor.index')->with('success', 'Instructor deleted successfully');
            } elseif ($user->role == 'staff') {
                return redirect()->route('staff.instructor.index')->with('success', 'Instructor deleted successfully');
            }
    
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
    
            // Return back with an error
            return back()->withErrors(['error' => 'An error occurred while deleting the instructor. Please try again.']);
        }

        if ($user->role == 'admin' || $user->role == 'superadmin') {
            return redirect()->route('admin.instructor.index')->with('error', 'Opps! Error deleting the record.');
        } elseif ($user->role == 'staff') {
            return redirect()->route('staff.instructor.index')->with('error', 'Opps! Error deleting the record.');
        }
    }    
}