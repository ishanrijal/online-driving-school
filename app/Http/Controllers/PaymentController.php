<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// the payemnt table is like a fee table.

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payments::with('admin')->paginate(10);
        return view('payment.payment-list', compact('payments'));
    }

    public function create()
    {
        return view('payment.generate-payment');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'Date' => 'required|date',
            'Type' => 'required|string',
        ]);

        if( $user->role == 'superadmin' || $user->role == 'admin' ){
           $adminID = $user->admin->AdminID;
        }else{
            $adminID = null;
        }
        Payments::create([
            'Date'    => $request->Date,
            'Type'    => $request->Type,
            'AdminID' => $adminID,
            'InvoiceID' => null
        ]);

        if( $user->role == 'superadmin' || $user->role == 'admin' ){
            return redirect()->route('admin.payment.index')->with('success', 'Payment added successfully.');
         }else{
            return redirect()->route('staff.payment.index')->with('success', 'Payment added successfully.');
         }
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
