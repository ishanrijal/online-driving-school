<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedules;
use App\Models\Courses;
use App\Models\Instructors;
use App\Models\Students;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $instructors = Instructors::all();
        $students = Students::all();
        $courses = Courses::all();
    
        // Retrieve all class schedules (appointments)
        $appointments = ClassSchedules::all()->map(function($appointment) {
            dd($appointment);
            return [
                'id' => $appointment->ClassScheduleID,
                'name' => $appointment->Location, 
                'start' => $appointment->Date,
                // 'end' => $appointment->end_date,
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
        ]);
        return redirect()->route('admin.classSchedule.index')->with('success', 'Schedule added successfully.');
    }

    public function getAppointments(){
    $schedules = ClassSchedules::all(); // Fetch all class schedules

    // Format the data for FullCalendar
    $events = $schedules->map(function ($schedule) {
        return [
            'id' => $schedule->ClassScheduleID,
            'title' => 'Class Appointment', // You can customize this
            'start' => $schedule->Date . 'T' . $schedule->Time, // Combine date and time
            'end' => $schedule->Date . 'T' . $schedule->Time, // Adjust as needed if you have an end time
            'description' => $schedule->Location, // Add more details if needed
        ];
    });

    return response()->json($events);
}

}
