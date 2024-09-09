<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\Students;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

        /**
     * Display a listing of trainers.
     */
    public function index()
    {
        $students = Students::paginate(10);
        return view( 'admin.students', compact('students') );
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        return view('admin.add-student');
    }

    /**
     * Store a newly created trainer in the database.
     */
    public function store(Request $request)
    {
        // dd($request);
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
            'LicenseNumber' => $request->LicenseNumber,
            'Phone'         => $request->contact,
            'user_id'       => $user->user_id,
        ]);

        // Assuming $user is the instance of the registered user
        $user = User::find($user->user_id); // Replace with actual user retrieval logic

        // Send the email verification notification
        $user->notify(new VerifyEmail());

        return redirect()->route('admin.instructor.index')->with('success', 'Instructor added successfully. A verification email has been sent.');
    }

    /**
     * Show the form for editing a trainer.
     */
    public function edit($id)
    {
        // Retrieve the instructor based on the provided ID
        $instructor = Students::findOrFail($id);
        return view('admin.edit-student', compact('instructor'));
    }

    /**
     * Update the specified trainer in the database.
     */
    public function update(Request $request, $id){
        $students = Students::findOrFail($id);
        $request->validate([
            'name'           => 'required|string|max:255',
            // 'LicenseNumber'  => [
            //     'required',
            //     'string',
            //     Rule::unique('instructors', 'LicenseNumber')->ignore( $instructor->InstructorID, 'InstructorID' )
            // ],
            'contact'        => 'required|string|max:15',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user table (name only, as email and role should not be updated)
        $user = User::find($students->user_id);
        $user->update([
            'name' => $request->name,
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

        // // Update instructor details
        // $instructor->update([
        //     'Name'          => $request->name,
        //     'LicenseNumber' => $request->LicenseNumber,
        //     'Phone'         => $request->contact,
        //     'image'         => $imagePath,
        // ]);

        return redirect()->route('admin.instructor.index')->with('success', 'Instructor updated successfully');
    }

    /**
     * Remove the specified trainer from the database.
     */
    public function destroy($id)
    {

        $instructor = Instructors::findOrFail($id);
        $userId = $instructor->user_id;
    
        // Delete the instructor
        $instructor->delete();

        // Manually delete the associated user
        User::find($userId)?->delete();
        
        return redirect()->route('admin.instructor.index')->with('success', 'Instructor deleted successfully');
    }
}