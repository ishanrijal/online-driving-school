@extends('student.layout')
@section('title', 'Invoices')
@section('content')
    @if(session('success'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ session('success') }} <!-- Changed from 'error' to 'success' -->
                </div>
            </div>
        </div>
    @endif

    <div class="payment-container">
        <div id="course-purchase-info" class="box-shadow">
            <div class="info-box">
                @if(isset($course))
                    <label for="appointment-date">Price To Pay:</label>
                    <p id="appointment-date">$.{{$course->Price}}</p>
                    <input type="hidden" name="course_id" value="{{ $course->CourseID }}">
                @elseif(isset($invoice))
                    <label for="appointment-date">Invoice Amount:</label>
                    <p id="appointment-date">$.{{$invoice->TotalAmount}}</p>
                    <input type="hidden" name="invoice_id" value="{{ $invoice->InvoiceID }}">
                @else
                    <p>No course or invoice information available.</p>
                @endif
            </div>
        </div>

        <form class="payment-form box-shadow" action="{{ isset($invoice) ? route('student.invoice.update', $invoice->InvoiceID) : route('payment.process') }}" method="{{ isset($invoice) ? 'POST' : 'POST' }}">
            @csrf
            @if(isset($course))
                <input type="hidden" name="course_id" value="{{ $course->CourseID }}" required>
            @elseif(isset($invoice))
                <input type="hidden" name="invoice_id" value="{{ $invoice->InvoiceID }}" required>
                @method('PUT') <!-- Add this line to indicate the PUT method -->
            @endif

            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input placeholder="XXXXXXXXXXXXXXXX" type="text" name="card_number" id="card_number" value="{{ old('card_number') }}" required>
            </div>
            @error('card_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="text" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" required placeholder="MM/YY">
            </div>
            @error('expiry_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="form-group">
                <label for="cvv">CVV</label>
                <input placeholder="XXX" type="text" name="cvv" id="cvv" value="{{ old('cvv') }}" required>
            </div>
            @error('cvv')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="form-group">
                <label for="amount">Amount</label>
                <input placeholder="0.0" type="number" name="amount" id="amount" value="{{ old('amount') }}" required>
            </div>
            <div class="form-group">
                @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <br/>

            <button type="submit" class="btn btn-primary">Make Payment</button>
        </form>        
    </div>
@endsection