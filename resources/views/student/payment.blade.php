@extends('student.layout')
@section('title', 'Invoices')
@section('content')
    <div class="payment-container">
        <div id="course-purchase-info" class="box-shadow">
            <div class="info-box">
                <label for="appointment-date">Course Name:</label>
                <p id="appointment-date">{{$course->Name}}</p>
            </div>
            <div class="info-box">
                <label for="appointment-date">Course Price:</label>
                <p id="appointment-date">$.{{$course->Price}}</p>
            </div>
        </div>
        
        <form action="{{ route('payment.process') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" id="course_id" value="{{ $course->CourseID }}" required>
        
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}" required>
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
                <input type="text" name="cvv" id="cvv" value="{{ old('cvv') }}" required>
            </div>
            @error('cvv')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required>
            </div>
            @error('amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <br/>
        
            <button type="submit" class="btn btn-primary">Make Payment</button>
        </form>
        
        
    </div>
@endsection