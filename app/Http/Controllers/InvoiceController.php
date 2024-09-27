<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Invoices;
use App\Models\Payments;
use App\Models\StudentProfiles;
use App\Models\Students;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function showPaymentForm($id){

        // Check if the ID corresponds to a course ID or an invoice ID
        $course = Courses::find($id);
        $invoice = Invoices::find($id);
        
        if ($course) {
            dd('couse');
            return view('student.payment', compact('course'));
        }

        if ($invoice) {
            return view('student.payment', compact('invoice'));
        }

        return redirect()->route('student.dashboard')->with('error', 'Opps! Something went wrong.');
    }

    public function processPayment(Request $request)
    {
        // Validate payment details
        $user = Auth::user();
        try{
            $student = Students::where('user_id', $user->user_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('payment.show')->with('error', 'Opps!!! Something went wrong.');
        }
        $request->validate([
            'course_id' => 'required',
            'card_number' => 'required|digits:16',
            'expiry_date' => 'required',
            'cvv' => 'required|digits:3',
            'amount' => 'required|numeric',
        ]);

        $course = Courses::where('CourseID', $request->course_id)->firstOrFail();
        
        // Check if the amount entered matches the course price
        if ($request->amount == $course->Price) {
            $studentProfile = StudentProfiles::create([
                'CourseID' => $request->course_id,
                'StudentID' => $student->StudentID, // Assuming the user is logged in
                'CourseEnrollDate' => now(),
                'PermitNumber' => $request->card_number
            ]);
            $invoice = Invoices::create([
                'Date' => now(),
                'TotalAmount'   => $request->amount,
                'Status'   => 'paid',
                'StudentID' => $student->StudentID, // Assuming the user is logged in
            ]);
            Payments::create([
                'InvoiceID' => $invoice->InvoiceID, // Use the newly created InvoiceID
                'Date' => now(),
                'Type' => 'course fee',
                'AdminID' => null, // Set AdminID to null
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
        $user = Auth::user();
        if( ($user->role=='superadmin') || ($user->role=='admin') ){
            $adminID = $user->admin->AdminID;
        }else{
            $adminID = null;
        }
        $request->validate([
            'Date' => 'required|date',
            'TotalAmount' => 'required|numeric',
            'Status' => 'string',
            'StudentID' => 'required|numeric', 
        ]);
        
        $invoice = Invoices::create([
            'Date' => $request->Date,
            'TotalAmount' => $request->TotalAmount,
            'Status' => 'unpaid', // Default status
            'StudentID' => $request->StudentID, 
        ]);
        Payments::create([
            'InvoiceID' => $invoice->InvoiceID, // Use the newly created InvoiceID
            'Date' => now(),
            'Type' => 'course fee',
            'AdminID' => $adminID, // Set AdminID to null
        ]);

        // $invoice->students()->attach($request->StudentID);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = Invoices::with('student','payments')->findOrFail($id);
        return view('invoice.invoice-edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TotalAmount' => 'required|numeric',
            'Status' => 'required|string',
            'Type' => 'required|string',
        ]);

        $invoice = Invoices::findOrFail($id);
        $invoice->update($request->only(['TotalAmount', 'Status']));

        $payment = Payments::where('InvoiceID', $id)->first();

        if ($payment) {
            $payment->update(['Type' => $request->Type]);
        } else {
            return redirect()->route('admin.invoice.index')->with('error', 'Payment record not found.');
        }
        
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoices::findOrFail($id);
        $invoice->delete();
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
