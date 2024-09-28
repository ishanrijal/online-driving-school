<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\StudentProfiles;
use App\Models\Students;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try{
            $student = Students::where('user_id', $user->user_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('student.dashboard')->with('course_error', 'Opps!!! Course List not available now.');
        }
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
        $user = Auth::user();
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Price' => 'required|string',
        ]);
        
        if ($user->role == 'admin' || $user->role == 'superadmin') {
            $admin_id = $user->admin->AdminID;
        }else{
            $admin_id = null;
        }

        Courses::create([
            'Name'        => $request->Name,
            'Description' => $request->Description,
            'Price'       => $request->Price,
            'AdminID'     => $admin_id,
        ]);

        if ($user->role == 'admin' || $user->role == 'superadmin') {
            return redirect()->route('admin.course.index')->with('success', 'Course added successfully.');
        }else{
            return redirect()->route('staff.course.index')->with('success', 'Course added successfully.');
        }       
    }

    public function edit($id)
    {
        $course = Courses::findOrFail($id);
        return view('course.edit-course', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Price' => 'required|string',
        ]);

        $course = Courses::findOrFail($id);
        $course->update($request->all());
        if ( $user->role == 'admin' || $user->role == 'superadmin' ) {
            return redirect()->route('admin.course.index')->with('success', 'Course updated successfully.');
        } else {
            return redirect()->route('staff.course.index')->with('success', 'Course updated successfully.');
        } 
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $course = Courses::findOrFail($id);
        $course->delete();
        if( $user->role=='admin' || $user->role=='superadmin' ) {
            return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
        }else{
            return redirect()->route('staff.course.index')->with('success', 'Course deleted successfully.');
        }
    }
}
