@extends('student.layout')
@section('title', 'Invoices List')
@section('content')
    <div class="content-wrapper">
        @if(session('success'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="header">
            <h3>Total Invoices: <span class="entity-count">{{ $invoices->count() }}</span></h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Invoice Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Student</th>
                    <th>Update Invoice Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->Date }}</td>
                    <td>{{ number_format($invoice->TotalAmount, 2) }}</td>
                    <td>{{ ucfirst($invoice->Status) }}</td>
                    <td>{{ $invoice->student->Name }}</td>

                    @if($invoice->Status !== 'paid')
                        <td class="action-btn">
                            <form action="{{ route('student.invoice.update', $invoice->InvoiceID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Mark this invoice as paid?');">
                                    Pay Now
                                </button>
                            </form>
                        </td>
                    @else
                        <td class="alert alert-success"> Already Paid </td>
                    @endif                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection