@extends('admin.layout')
@section('title', 'Add Trainer')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>New Trainer</h1>
            </div>
            <form action="{{ route('admin.instructor.store') }}" method="POST" enctype="multipart/form-data" id="trainer-form">
                @csrf
                <div class="form-group">
                    <div class="label-container">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="name" name="name" placeholder="Manohara KC" value="{{ old('name') }}" required>
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
                        <input type="text" id="contact" name="contact" placeholder="9800000000" value="{{ old('contact') }}" required>
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
                        <input type="text" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-container">
                        <label for="license">License Number</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="license" name="LicenseNumber" placeholder="2051" value="{{ old('LicenseNumber') }}" required>
                        @error('LicenseNumber')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-container">
                        <label for="image">Upload Image<br>(350*250)</label>
                    </div>
                    <div class="form-input">
                        <input type="file" id="image" name="image">
                        <small>These images are visible in the trainer box. Use (350x250) image size. Keep some blank space around the main object to make it responsive on different devices.</small>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Save button inside the form -->
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
@endsection