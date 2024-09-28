<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\Students;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    /**
     * Display a listing of trainers.
     */
    public function index()
    {
        $user = Auth::user();
        $students = Students::paginate(10);
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view( 'admin.students', compact('students') );
        }else{
            return view( 'staff.students', compact('students') );
        }
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view('admin.add-student');
        }else{
            return view('staff.add-student');
        }
    }

    /**
     * Store a newly created trainer in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'student',
            'password' => Hash::make($request->name),   // temporary password
        ]);

        Students::create([
            'Name'          => $request->name,
            'Phone'         => $request->contact,
            'user_id'       => $user->user_id,
        ]);

        // Assuming $user is the instance of the registered user
        $user = User::find($user->user_id); // Replace with actual user retrieval logic

        // Send the email verification notification
        $user->notify(new VerifyEmail());

        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return redirect()->route('admin.student.index')->with('success', 'Student added successfully.');
        }else{
            return redirect()->route('staff.student.index')->with('success', 'Student added successfully.');
        }
    }

    /**
     * Show the form for editing a trainer.
     */
    public function edit($id)
    {
        // Retrieve the instructor based on the provided ID
        $student = Students::findOrFail($id);
        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return view('admin.edit-student', compact('student'));
        }else{
            return view('staff.edit-student', compact('student'));
        }
    }

    /**
     * Update the specified trainer in the database.
     */
    public function update(Request $request, $id){
        $students = Students::findOrFail($id);
        $request->validate([
            'Name'        => 'required|string|max:255',
            'Address'     => 'nullable|string|max:255',
            'DateOfBirth' => 'nullable|date|max:255',
            'Gender'      => 'nullable|string|max:10',
            'Phone'       => 'nullable|numeric|max:255',
            // 'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user table (name only, as email and role should not be updated)
        $user = User::find($students->user_id);
        $user->update([
            'name' => $request->Name,
        ]);

        // Handle image upload if a new image is provided
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('instructors', 'public');
        //     // Delete old image if needed (optional)
        //     if ($instructor->image) {
        //         Storage::delete('public/' . $instructor->image);
        //     }
        // } else {
        //     $imagePath = $instructor->image; // retain the old image
        // }

        // Update instructor details
        $students->update([
            'Name'        => $request->Name,
            'Address'     => $request->Address,
            'DateOfBirth' => $request->DateOfBirth,
            'Gender'      => $request->Gender,
            'Phone'       => $request->Phone,
            // 'image'         => $imagePath,
        ]);

        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return redirect()->route('admin.student.index')->with('success', 'Student updated successfully');
        }else{
            return redirect()->route('staff.student.index')->with('success', 'Student updated successfully');
        }
    }

    /**
     * Remove the specified trainer from the database.
     */
    public function destroy($id)
    {

        $student = Students::findOrFail($id);
        $userId = $student->user_id;
    
        // Delete the student$student
        $student->delete();

        // Manually delete the associated user
        User::find($userId)?->delete();

        $user = Auth::user();
        if( ( $user->role == 'admin' || $user->role == 'superadmin') ){
            return redirect()->route('admin.student.index')->with('success', 'Student deleted successfully');
        }else{
            return redirect()->route('staff.student.index')->with('success', 'Student deleted successfully');
        }
    }
}