<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Payments;
use Illuminate\Http\Request;

// the payemnt table is like a fee table.

class PaymentController extends Controller
{
    public function index()
    {
        // $payments = Payments::all();
        // return view('payments.index', compact('payments'));
        $payments = Payments::with('admin')->paginate(10);
        return view('payment.payment-list', compact('payments'));
    }

    public function create()
    {
        return view('payment.generate-payment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Date' => 'required|date',
            'Type' => 'required|string',
        ]);

        $user_id = auth()->user()->user_id;

        // Retrieve the AdminID from the admin table using the user_id
        $admin = Admin::where('user_id', $user_id)->first();

        Payments::create([
            'Date'    => $request->Date,
            'Type'    => $request->Type,
            'AdminID' => $admin->AdminID,
        ]);

        // $invoice->students()->attach($request->StudentID);
        return redirect()->route('admin.payment.index')->with('success', 'Payment added successfully.');
    }

    public function edit($id)
    {
        $payment = Payments::findOrFail($id);
        return view('payment.payment-edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Date' => 'required|date',
            'Type' => 'required|string',
        ]);
        $payment = Payments::findOrFail($id);
        $payment->update($request->all());
        return redirect()->route('admin.payment.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy($id)
    {
        $payment = Payments::findOrFail($id);
        $payment->delete();
        return redirect()->route('admin.payment.index')->with('success', 'Payment deleted successfully.');
    }
}
