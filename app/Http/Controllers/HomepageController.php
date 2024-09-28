<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(){
        $courses = Courses::with('admin')->get(); // Retrieve all courses with admin relationship
        return view('home', compact('courses'));
    }
}
