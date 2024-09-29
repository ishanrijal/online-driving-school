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

        @if($invoices->isEmpty())
            <div class="alert alert-info">
                No invoices Available.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Invoice Due Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Type</th>
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
                        <td style="text-transform:capitalize">{{$invoice->payments->Type}}</td>

                        @if($invoice->Status !== 'paid')
                            <td class="action-btn">
                                <a href={{ route('payment.show', $invoice->InvoiceID) }} class="btn btn-primary">
                                    Pay Now
                                </a>
                            </td>
                        @else
                            <td class="alert alert-success"> Already Paid </td>
                        @endif                
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection