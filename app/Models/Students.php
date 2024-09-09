<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{

    use HasFactory;

    protected $primaryKey = 'StudentID';
    
    protected $fillable = [
        'Name', 'Address', 'DateOfBirth', 'Gender', 'image', 'Phone', 'Email', 'user_id',
    ];

    // Relationship with User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}