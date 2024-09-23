<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentInvoiceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $student = Students::where('user_id', $userId)->first();

        if ($student) {
            $invoices = Invoices::where('StudentID', $student->StudentID)->with('student')->get(); ;
        } else {
            $invoices = collect([]);
        }    
        // Return the view with the invoices belonging to the current student's user
        return view('student.invoice-list', compact('invoices'));
    }
    public function update(Request $request, $id)
    {
        $invoice = Invoices::findOrFail($id);
        $invoice->update([
            'Status' => 'paid'
        ]);
        return redirect()->route('student.invoice.index')->with('success', 'Invoice Status updated successfully.');
    }
}
