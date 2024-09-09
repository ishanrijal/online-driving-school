@extends('admin.layout')
@section('title', 'Edit Trainer')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>Edit Trainer</h1>
            </div>
 
            <form action="{{ route('admin.instructor.update', $instructor->InstructorID) }}" method="POST" enctype="multipart/form-data" id="trainer-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="label-container">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="name" name="name" value="{{ old('name', $instructor->Name) }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="label-container">
                        <label for="contact">Contact No</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="contact" name="contact" value="{{ old('contact', $instructor->Phone) }}" required>
                        @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="label-container">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="email" name="email" value="{{ $instructor->user->email }}" disabled>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="label-container">
                        <label for="license">License Number</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="license" name="LicenseNumber" value="{{ old('LicenseNumber', $instructor->LicenseNumber) }}" required>
                        @error('LicenseNumber')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-container">
                        <label for="role">Role</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="role" name="role" value="Instructor" disabled>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="label-container">
                        <label for="image">Current Image</label>
                    </div>
                    <div class="form-input">
                        {{-- {{dd($instructor->image)}} --}}
                        <img src="{{ asset('storage/' . $instructor->image) }}" alt="Instructor Image" width="100" height="70">
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-container">
                        <label for="image">Replace Image<br>(350*250)</label>
                    </div>
                    <div class="form-input">
                        <input type="file" id="image" name="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <button type="button" class="save-btn" onclick="event.preventDefault(); document.getElementById('reset-form').submit();">
                            Reset Password
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="save-btn">Update</button>
                </div>
            </form>

            <form id="reset-form" action="{{ route('password.email') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="email" value="{{ $instructor->user->email }}">
            </form>
        </div>
    </div>
@endsection