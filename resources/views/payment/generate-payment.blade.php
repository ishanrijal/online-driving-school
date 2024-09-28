@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $paymentStore = route('admin.payment.store');
    }  else{
        $role = 'staff';
        $paymentStore = route('staff.payment.store');
    } 
@endphp

@extends($role. '.layout')
@section('title', 'Add Payment')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>Add Payment</h1>
            </div>
            <form action="{{ $paymentStore }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
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
