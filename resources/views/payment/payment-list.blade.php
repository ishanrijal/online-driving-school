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
            <h3>Total Payments: <span class="entity-count">{{ $payments->count() }}</span></h3>
            <div class="actions-container">
                <a href="{{ route('admin.payment.create') }}"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add Payment</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Payment Date</th>
                    <th>Payment Type</th>
                    <th>Admin ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->Date }}</td>
                    <td>{{ ucfirst($payment->Type) }}</td>
                    <td>{{ $payment->admin->AdminID }}</td>
                    <td class="action-btn">
                        <a href="{{ route('admin.payment.edit', $payment->PaymentID) }}"> 
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ route('admin.payment.destroy', $payment->PaymentID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this payment?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Optional pagination, if using paginate -->
        @if(method_exists($payments, 'links'))
            <x-pagination :paginator="$payments" />
        @endif
    </div>
@endsection