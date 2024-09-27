<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $primaryKey = 'PaymentID';

    protected $fillable = [
        'InvoiceID',
        'Date',
        'Type',
        'AdminID',
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'InvoiceID', 'InvoiceID');
    }
}
