<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';
    protected $primaryKey = 'AdminID';
    
    protected $fillable = [
        'Name', 'Address', 'DateOfBirth', 'Gender', 'image', 'Phone', 'Email', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payments(){
        return $this->hasMany(Payments::class, 'AdminID', 'AdminID');
    }
    public function course(){
        return $this->hasMany(Courses::class, 'AdminID', 'AdminID');
    }
}
