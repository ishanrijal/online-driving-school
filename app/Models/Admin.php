<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $primaryKey = 'AdminID';
    
    protected $fillable = [
        'Name', 'Address', 'DateOfBirth', 'Gender', 'image', 'Phone', 'Email', 'user_id',
    ];
}
