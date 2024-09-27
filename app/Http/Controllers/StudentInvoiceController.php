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
            $invoices = Invoices::with('payments')->where('StudentID', $student->StudentID)->get();
        } else {
            $invoices = collect([]);
        }
        // Return the view with the invoices belonging to the current student's user
        return view('student.invoice-list', compact('invoices'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_id' => 'required',
            'card_number' => 'required|digits:16',
            'expiry_date' => 'required',
            'cvv' => 'required|digits:3',
            'amount' => 'required|numeric',
        ]);
        $invoice = Invoices::findOrFail($id);

        if ($request->amount == $invoice->TotalAmount) {
            $invoice->update([
                'Status' => 'paid'
            ]);
            return redirect()->route('student.invoice.index')->with('success', 'You have successfuly paid the invoice.');
        }
        return  redirect()->back()->withInput()->withErrors(['amount' => 'The amount entered does not match the course price.']);
    }
}
