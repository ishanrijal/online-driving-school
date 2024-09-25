<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructors extends Model
{
    use HasFactory;

    protected $primaryKey = 'InstructorID';
    
    protected $fillable = [
        'Name', 'LicenseNumber', 'Phone', 'Address','Gender', 'user_id', 'image',
    ];

    // Relationship with User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
