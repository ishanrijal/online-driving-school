<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $primaryKey = 'InvoiceID';

    protected $fillable = [
        'Date',
        'TotalAmount',
        'Status',
        'StudentID'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'StudentID', 'StudentID');
    }
}
