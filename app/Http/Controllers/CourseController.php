<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\StudentProfiles;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Courses::with('admin')->paginate(10);
        $user = Auth::user();
        return view('course.course-list', compact('courses', 'user'));
    }
    public function studentCourse()
    {
        $courses = Courses::with('admin')->get();
        $user = Auth::user();
        $student = Students::findOrFail($user->user_id);
        
        $studentProfiles = StudentProfiles::where('StudentID', $student->StudentID)->get();
        
        $enrolledCourseIds = $studentProfiles->pluck('CourseID')->toArray();

         // Check if there are no enrolled courses
        if (empty($enrolledCourseIds)) {
            // Set enroll_status to false for all courses
            foreach ($courses as $course) {
                $course->enroll_status = false;
            }
        } else {
            // Add enroll_status to each course based on whether it's in the enrolledCourseIds
            foreach ($courses as $course) {
                $course->enroll_status = in_array($course->CourseID, $enrolledCourseIds);
            }
        }
        // $course_enroll = Courses::with('admin')->get();
        return view('student.course', compact('courses'));
    }
    public function studentCourseList()
    {
        $user = Auth::user();
        $student =Students::where('user_id', $user->user_id)->first();

        if ($student) {
            $classSchedules = StudentProfiles::where('StudentID', $student->StudentID)
                ->with(['course','student'])
                ->get();
            return view('student.enrolled-course-list', compact('classSchedules'));
        }
        return redirect()->route('student.enrolled-course-list')->with('error', 'Not Enrolled into any courses.');
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
