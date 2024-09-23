<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\Instructors;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableScheduler extends Controller
{
    //
    public function index(){

        $instructors = Instructors::all();
        $courses     = Courses::all();
        

        // Get the ID of the currently authenticated user
        $userId = Auth::id();

        // Retrieve the student record for the logged-in user
        $student = Students::where('user_id', $userId)->first();

        // Check if a student record exists
        if ($student) {
            $classSchedules = ClassSchedules::where('StudentID', $student->StudentID)->get();
        } else {
            // Handle the case where no student record exists
            $classSchedules = collect(); // Return an empty collection or handle as needed
        }
        $appointments = ClassSchedules::where('StudentID', $student->StudentID)
        ->get()
        ->map(function($appointment) {
            return [
                'id'    => $appointment->ClassScheduleID,
                'title' => $appointment->Location,          // Customize this as needed
                'start' => $appointment->Date,              // Assuming you just want the date
                  // 'end' => $appointment->end_date, // If you have an end date, add it here
            ];
        });
        return view('student.time-table', compact('instructors', 'courses','appointments'));
    }

    public function edit($id)
    {
        $schedule = ClassSchedules::findOrFail($id);
        return response()->json([
            'ClassScheduleID' => $schedule->ClassScheduleID,
            'Date' => $schedule->Date,
            'Time' => $schedule->Time,
            'Location' => $schedule->Location,
            'InstructorID' => $schedule->InstructorID,
            'InstructorName' => $schedule->instructor->Name, // Assuming you have a relationship set up
            'CourseID' => $schedule->CourseID,
            'CourseName' => $schedule->course->Name, // Assuming you have a relationship set up
            'StudentID' => $schedule->StudentID,
            'StudentName' => $schedule->student->Name // Assuming you have a relationship set up
        ]);
        // return view('course.edit-course', compact('course'));
    }

    public function store(Request $request){
        
        $request->validate([
            'Date'         => 'required|date',
            'Time'         => 'required',
            'Location'     => 'required|string',
            'InstructorID' => 'required|exists:instructors,InstructorID',
            'CourseID' => 'required|exists:courses,CourseID',
        ]);
        ClassSchedules::create([
            'Date' => $request->Date,
            'Time' => $request->Time,
            'Location' => $request->Location,
            'InstructorID' => $request->InstructorID,
            'CourseID' => $request->CourseID,
            'StudentID' => Auth::id(),
        ]);
        return redirect()->route('student.time-table.index')->with('success', 'Class Book successfully.');
    }

    public function destroy($id)
    {
        $schedule = ClassSchedules::findOrFail($id);
        $schedule->delete();
        return redirect()->route('student.time-table.index')->with('success', 'Schedule deleted successfully.');
    }
}
