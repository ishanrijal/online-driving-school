@extends('admin.layout')
@section('title', 'Generate Invoice')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>Add Payment</h1>
            </div>
            <form action="{{ route('admin.payment.store') }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
                <!-- Date Field -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Payment Issued By</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="number" 
                            id="AdminID" 
                            name="AdminID" 
                            value="{{ auth()->user()->user_id }}" 
                            required
                            disabled
                        >
                        @error('AdminID')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Payment Date</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="date" 
                            id="date" 
                            name="Date" 
                            placeholder="Select Date" 
                            value="{{ old('Date') ?? $payments->Date ?? '' }}" 
                            required
                        >
                        @error('Date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-container">
                        <label for="total_amount">Payment Type</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="text" 
                            id="Type" 
                            name="Type" 
                            placeholder="Enter Type i.e. course fee, registration fee" 
                            value="{{ old('Type') ?? $payments->Type ?? '' }}" 
                            required
                        >
                        @error('Type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Save Button -->
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
@endsection
