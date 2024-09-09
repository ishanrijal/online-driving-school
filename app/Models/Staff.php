<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $primaryKey = 'StaffID';
    
    protected $fillable = [
        'Name', 'Address', 'DateOfBirth', 'Gender', 'image', 'Phone', 'Email', 'AdminID',
    ];

    // // Relationship with User
    // public function admin(){
    //     return $this->belongsTo(Admin::class, 'user_id');
    // }
}
