<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfiles extends Model
{
    use HasFactory;

    protected $primaryKey = 'StudentProfileID';

    protected $fillable = [
        'CourseEnrollDate', // Updated to reflect the new column name
        'PermitNumber',
        'StudentID',
        'CourseID',
    ];

    // Define the relationship with Courses
    public function course()
    {
        return $this->belongsTo(Courses::class, 'CourseID', 'CourseID');
    }
    public function student()
    {
        return $this->belongsTo(Students::class, 'StudentID', 'StudentID');
    }
}
