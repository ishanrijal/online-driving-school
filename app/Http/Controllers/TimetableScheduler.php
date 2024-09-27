<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\Instructors;
use App\Models\Staff;
use App\Models\StudentProfiles;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableScheduler extends Controller
{
    //
    public function index(){
        $instructors = Instructors::all();
        $courses     = Courses::all();
        
        $user = Auth::user();
        $userId = $user->user_id;
        switch ($user->role) {
            case 'instructor':
                // Check if a student record exists
                if ($user->instructor) {
                    $appointments = ClassSchedules::where('InstructorID', $user->instructor->InstructorID)->get()->map(function($appointment) {
                        return [
                            'id'    => $appointment->ClassScheduleID,
                            'title' => $appointment->Location,          // Customize this as needed
                            'start' => $appointment->Date,              // Assuming you just want the date
                            // 'end' => $appointment->end_date, // If you have an end date, add it here
                        ];
                    });
                } else {
                    $appointments = collect(); // Return an empty collection or handle as needed
                }                
                return view('instructor.time-table', compact('instructors', 'courses','appointments')); 
            break;

            case 'student':
                // Retrieve the student record for the logged-in user
                $student = Students::where('user_id', $userId)->first();
                // Check if a student record exists
                if ($student) {
                    $classSchedules = StudentProfiles::where('StudentID', $student->StudentID)->with('course')->get();
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
                return view('student.time-table', compact('instructors', 'classSchedules','appointments'));
            break;

            default:
            break;
        }
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
            'InstructorName' => $schedule->instructor->Name,
            'CourseID' => $schedule->CourseID,
            'CourseName' => $schedule->course->Name, 
            'StudentID' => $schedule->StudentID,
            'StudentName' => $schedule->student->Name, 
            'CourseDescription' => $schedule->course->Description 
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'Date'         => 'required|date',
            'Time'         => 'required',
            'Location'     => 'required|string',
            'InstructorID' => 'required|exists:instructors,InstructorID',
            'CourseID' => 'required|exists:student_profiles,CourseID',
        ]);
        try {
            ClassSchedules::create([
                'Date'         => $request->Date,
                'Time'         => $request->Time,
                'Location'     => $request->Location,
                'InstructorID' => $request->InstructorID,
                'CourseID'     => $request->CourseID,
                'StudentID'    => Auth::id(),
            ]);
            return redirect()->route('student.time-table.index')->with('success', 'Class booked successfully.');
    
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'There was an issue booking the class. Please try again.']);
        }
    }

    public function destroy($id)
    {
        $schedule = ClassSchedules::findOrFail($id);
        $schedule->delete();
        return redirect()->route('student.time-table.index')->with('success', 'Schedule deleted successfully.');
    }
}
