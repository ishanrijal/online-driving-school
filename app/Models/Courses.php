<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $primaryKey = 'CourseID';

    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'AdminID'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }
    public function classSchedules()
    {
        return $this->hasMany(ClassSchedules::class, 'CourseID', 'CourseID'); // Adjust the foreign key and local key as necessary
    }
}
