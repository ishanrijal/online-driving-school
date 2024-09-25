@extends('admin.layout')
@section('title', 'Generate Invoice')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>Invoice List</h1>
            </div>
            <form action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
                <!-- Date Field -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Invoice Date</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="date" 
                            id="date" 
                            name="Date" 
                            placeholder="Select Date" 
                            value="{{ old('Date') ?? $invoice->Date ?? '' }}" 
                            required
                        >
                        @error('Date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Total Amount Field -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="total_amount">Total Amount</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="number" 
                            id="total_amount" 
                            name="TotalAmount" 
                            placeholder="Enter total amount" 
                            value="{{ old('TotalAmount') ?? $invoice->TotalAmount ?? '' }}" 
                            required
                        >
                        @error('TotalAmount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Student Dropdown with Select2 for Multiple Selections -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="student_id">Select Students</label>
                    </div>
                    <div class="form-input">
                        <select 
                            class="form-control" 
                            id="student_id" 
                            name="StudentID" 
                            required
                        >
                            <option value="">Select Students</option>
                            @foreach($students as $student)
                                <option value="{{ $student->StudentID }}" {{ (collect(old('StudentID'))->contains($student->StudentID)) ? 'selected' : '' }}>
                                    {{ $student->Name }} ({{ $student->LicenseNumber ? $student->LicenseNumber : 'null' }})
                                </option>
                            @endforeach
                        </select>
                        @error('StudentID')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Status Field (Default to "unpaid") -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="status">Invoice Status</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="text" 
                            id="status" 
                            name="Status" 
                            value="unpaid" 
                            disabled
                        >
                    </div>
                </div>

                <!-- Save Button -->
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
@endsection