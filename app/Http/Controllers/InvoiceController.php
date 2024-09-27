<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Invoices;
use App\Models\StudentProfiles;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoices::with('student')->paginate(10);
        return view('invoice.invoice-list', compact('invoices'));
    }

    // show the payment form for the student to purhase the course
    function showPaymentForm($courseId){
        $course = Courses::findOrFail($courseId);
        return view('student.payment', compact('course'));
    }

    public function processPayment(Request $request)
    {
        // Validate payment details
        $user = Auth::user();
        $student = Students::findOrFail($user->user_id);

        $request->validate([
            'course_id' => 'required',
            'card_number' => 'required|digits:16',
            'expiry_date' => 'required',
            'cvv' => 'required|digits:3',
            'amount' => 'required|numeric',
        ]);
        
        $course = Courses::findOrFail($request->course_id);

        // Check if the amount entered matches the course price
        if ($request->amount == $course->Price) {
            StudentProfiles::create([
                'CourseID' => $request->course_id,
                'StudentID' => $student->StudentID, // Assuming the user is logged in
                'CourseEnrollDate' => now(),
                'PermitNumber' => $request->card_number
            ]);
            Invoices::create([
                'Date' => now(),
                'TotalAmount'   => $request->amount,
                'Status'   => 'paid',
                'StudentID' => $student->StudentID, // Assuming the user is logged in
            ]);
            return redirect()->route('student.courses')->with('success', 'You have successfully enrolled in the course.');
        }
        return  redirect()->back()->withInput()->withErrors(['amount' => 'The amount entered does not match the course price.']);
    }

    public function create()
    {
        $students = Students::all();
        return view('invoice.generate-invoice', compact('students') );
    }

    public function store(Request $request)
    {
        $request->validate([
            'Date' => 'required|date',
            'TotalAmount' => 'required|numeric',
            'Status' => 'string',
            'StudentID' => 'required|numeric', 
        ]);
        
        Invoices::create([
            'Date' => $request->Date,
            'TotalAmount' => $request->TotalAmount,
            'Status' => 'unpaid', // Default status
            'StudentID' => $request->StudentID, 
        ]);

        // $invoice->students()->attach($request->StudentID);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = Invoices::with('student')->findOrFail($id);
        return view('invoice.invoice-edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TotalAmount' => 'required|numeric',
            'Status' => 'required|string',
        ]);

        $invoice = Invoices::findOrFail($id);
        $invoice->update($request->all());
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoices::findOrFail($id);
        $invoice->delete();
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
