<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{

        /**
     * Display a listing of trainers.
     */
    public function index()
    {
        $staffs = Staff::paginate(10);
        return view( 'admin.staff', compact('staffs') );
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        return view('admin.add-staff');
    }

    /**
     * Store a newly created trainer in the database.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|string|in:admin,staff',
        ]);    
        // Start the transaction
        DB::beginTransaction();
    
        try {
            // Create the user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => $request->role,
                'password' => Hash::make($request->name),   // temporary password
            ]);   
            // Create the admin
            $admin = Admin::create([
                'user_id' => $user->user_id,
            ]);    
            // Create the staff
            Staff::create([
                'Name'    => $request->name,
                'AdminID' => $admin->AdminID,
            ]);
            // Send the email verification notification
            $user->notify(new VerifyEmail());
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            return redirect()->route('admin.staff.index')->with('success', 'Staff added successfully. A verification email has been sent.');
    
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
    
            // Handle the error, log it, or display an error message
            return redirect()->back()->withErrors('An error occurred while processing the request. Please try again.');
        }
    }

    /**
     * Show the form for editing a trainer.
     */
    public function edit( $id )
    {
        // Retrieve the instructor based on the provided ID
        $staff = Staff::findOrFail( $id );
        return view('admin.edit-staff', compact('staff'));
    }

    /**
     * Update the specified trainer in the database.
     */
    public function update( Request $request, $id ){
        $staff = Staff::findOrFail( $id );
        $request->validate([
            'Name'        => 'required|string|max:255',
            'Address'     => 'nullable|string|max:255',
            'DateOfBirth' => 'nullable|date|max:255',
            'Gender'      => 'nullable|string|max:10',
            'Phone'       => 'nullable|numeric|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:9048',
        ]);

        // Update user table (name only, as email and role should not be updated)
        $user = Admin::find($staff->AdminID);
        $user = User::find($user->user_id);
        $user->update([
            'name' => $request->Name,
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('instructors', 'public');
            // Delete old image if needed (optional)
            if ($staff->image) {
                Storage::delete('public/' . $staff->image);
            }
        } else {
            $imagePath = $staff->image; // retain the old image
        }

        // Update instructor details
        $staff->update([
            'Name'        => $request->Name,
            'Address'     => $request->Address,
            'DateOfBirth' => $request->DateOfBirth,
            'Gender'      => $request->Gender,
            'Phone'       => $request->Phone,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully');
    }

    /**
     * Remove the specified trainer from the database.
     */
    public function destroy($id)
    {
        // Find the staff, if not found, return with an error
        $staff = Staff::find($id);
        if (!$staff) {
            return redirect()->route('admin.staff.index')->withErrors('Staff not found.');
        }
        
        // Retrieve the related admin and user information
        $adminID = $staff->AdminID;
        $admin = Admin::find($adminID);
        if ($admin) {
            $userId = $admin->user_id;
            
            // Delete the admin record
            $admin->delete();
    
            // Delete the user if found
            User::find($userId)?->delete();
        }
    
        // Delete the staff
        $staff->delete();
    
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully');
    }
}