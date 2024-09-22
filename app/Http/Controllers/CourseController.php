<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Courses::with('admin')->paginate(10);
        return view('course.course-list', compact('courses'));
    }

    public function create()
    {
        return view('course.add-course');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Price' => 'required|string',
        ]);

        $admin_id = auth()->user()->admin->AdminID;


        Courses::create([
            'Name'        => $request->Name,
            'Description' => $request->Description,
            'Price'       => $request->Price,
            'AdminID'     => $admin_id,
        ]);

        // $invoice->students()->attach($request->StudentID);
        return redirect()->route('admin.course.index')->with('success', 'Course added successfully.');
    }

    public function edit($id)
    {
        $course = Courses::findOrFail($id);
        return view('course.edit-course', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Price' => 'required|string',
        ]);

        $course = Courses::findOrFail($id);
        $course->update($request->all());
        return redirect()->route('admin.course.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Courses::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
    }
}
