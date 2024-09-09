<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;

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
        Instructor::create([
            'Name' => $request->name,
            'LicenseNumber' => $request->license,
            'Phone' => $request->contact,
            'user_id' => Auth::id(), // Get the currently logged-in user ID
            'image' => $imagePath, // Save the image path if uploaded
        ]);

        return redirect()->route('admin.trainer')->with('success', 'Trainer added successfully!');
    }
}
