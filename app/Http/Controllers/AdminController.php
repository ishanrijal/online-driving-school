<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Instructors;
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
        $request->validate([
            'name'           => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);        
        // Update user table (name only, as email and role should not be updated)
        $user = User::find($admin->user_id);
        $user->update([
            'name' => $request->name,
        ]);
        // dd($request);
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

        if( $imagePath ){
            $imageUrl = asset('storage/' . $imagePath);
        }else{
            $imageUrl='';
        }

        Session::put('staff_image_url', $imageUrl);
        $user = Auth::user();
        if( $user->role == 'superadmin' ){
            return redirect()->route('profile.index')->with('success', 'You Profile updated successfully');
        }
    }
}
