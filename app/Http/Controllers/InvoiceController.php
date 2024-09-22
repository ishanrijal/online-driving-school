<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Students;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoices::with('student')->paginate(10);
        return view('invoice.invoice-list', compact('invoices'));
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
