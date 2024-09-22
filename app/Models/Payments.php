<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $primaryKey = 'PaymentID';

    protected $fillable = [
        'Date',
        'Type',
        'AdminID',
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }
}
