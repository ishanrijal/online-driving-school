<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $primaryKey = 'StaffID';
    
    protected $fillable = [
        'Name', 'Address', 'DateOfBirth', 'Gender', 'image', 'Phone', 'Email', 'AdminID', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
