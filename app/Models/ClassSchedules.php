<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedules extends Model
{
    use HasFactory;
    protected $primaryKey = 'ClassScheduleID';

    protected $fillable = [
        'Date',
        'Time',
        'Location',
        'InstructorID',
        'CourseID',
        'StudentID',
    ];

    // Define the relationship with Students
    public function student()
    {
        return $this->belongsTo(Students::class, 'StudentID');
    }
    public function instructor()
    {
        return $this->belongsTo(Instructors::class, 'InstructorID');
    }
    public function course()
    {
        return $this->belongsTo(Courses::class, 'CourseID');
    }
}
