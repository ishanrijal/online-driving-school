<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\Instructors;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $instructors = Instructors::all();
        $students = Students::all();
        $courses = Courses::all();
    
        // Retrieve all class schedules (appointments)
        $appointments = ClassSchedules::all()->map(function($appointment) {
            return [
                'id' => $appointment->ClassScheduleID,
                'title' => $appointment->Location, // Customize this as needed (e.g., include student name or course)
                'start' => $appointment->Date, // Assuming you just want the date
                // 'end' => $appointment->end_date, // If you have an end date, add it here
            ];
        });
    
        // Pass the data to the view
        return view('schedule.class-schedule', compact('instructors', 'students', 'courses', 'appointments'));
    }
    public function store(Request $request){        
        $request->validate([
            'Date'         => 'required|date',
            'Time'         => 'required',
            'Location'     => 'required|string',
            'InstructorID' => 'required|exists:instructors,InstructorID',
            'CourseID' => 'required|exists:courses,CourseID',
            'StudentID' => 'required|exists:students,StudentID',
        ]);
        ClassSchedules::create([
            'Date' => $request->Date,
            'Time' => $request->Time,
            'Location' => $request->Location,
            'InstructorID' => $request->InstructorID,
            'CourseID' => $request->CourseID,
            'StudentID' => $request->StudentID,
            'class_status'=> 'pending'
        ]);
        $user= Auth::user();
        if( $user->role== 'admin' || $user->role== 'superadmin'){
            return redirect()->route('admin.classSchedule.index')->with('success', 'Schedule added successfully.');
        }else{
            return redirect()->route('staff.classSchedule.index')->with('success', 'Class added successfully.');
        }
        
    }

    public function getAppointments(){
    $schedules = ClassSchedules::all(); // Fetch all class schedules

    // Format the data for FullCalendar
    $events = $schedules->map(function ($schedule) {
        return [
            'id' => $schedule->ClassScheduleID,
            'title' => 'Class Appointment',
            'start' => $schedule->Date . 'T' . $schedule->Time, 
            'end' => $schedule->Date . 'T' . $schedule->Time,
            'description' => $schedule->Location,
        ];
    });

    return response()->json($events);
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
            'class_status' => $schedule->class_status, 
        ]);
        // return view('course.edit-course', compact('course'));
    }
    public function editForm($id)
    {
        $schedule = ClassSchedules::findOrFail($id);
        $courses = Courses::all();
        $instructors = Instructors::all();
        $students = Students::all();

        return view('schedule.edit-schedule', compact('schedule', 'courses', 'instructors', 'students'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'Date'         => 'required|date',
            'Time'         => 'required',
            'Location'     => 'required|string',
            'InstructorID' => 'required|exists:instructors,InstructorID',
            'CourseID'     => 'required|exists:courses,CourseID',
            'StudentID'    => 'required|exists:students,StudentID',
        ]);

        $classSchedule = ClassSchedules::findOrFail($id);
        $classSchedule->update($request->all());

        if( $user->role== 'admin' || $user->role== 'superadmin'){
            return redirect()->route('admin.classSchedule.index')->with('success', 'Time Table updated successfully.');
        }else{
            return redirect()->route('staff.classSchedule.index')->with('success', 'Time Table updated successfully.');
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $schedule = ClassSchedules::findOrFail($id);
        $schedule->delete();
        if( $user->role== 'admin' || $user->role== 'superadmin'){
            return redirect()->route('admin.classSchedule.index')->with('success', 'Schedule deleted successfully.');
        }else{
            return redirect()->route('staff.classSchedule.index')->with('success', 'Schedule deleted successfully.');
        }
    }
}