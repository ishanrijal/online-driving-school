@extends('admin.layout')
@section('title', 'Invoices')
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
            <div class="actions-container">
                <a href="{{ route('admin.invoice.create') }}"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add Invoice</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Invoice Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Student</th>
                    <th>Actions</th>
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
                    <td class="action-btn">
                        <a href="{{ route('admin.invoice.edit', $invoice->InvoiceID) }}"> 
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ route('admin.invoice.destroy', $invoice->InvoiceID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this invoice?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Optional pagination, if using paginate -->
        @if(method_exists($invoices, 'links'))
            <x-pagination :paginator="$invoices" />
        @endif
    </div>
@endsection