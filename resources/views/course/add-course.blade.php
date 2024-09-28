@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $id = $user->admin->AdminID;
        $actionRoute = route('admin.course.store');
    } else {
        $role = 'staff';
        $id = null;
        $actionRoute = route('staff.course.store');
    }
@endphp

@extends($role.'.layout')
@section('title', 'Add Course')
@section('content')
    <div class="content-wrapper">
        <div class="form-container save-form">
            <div class="header">
                <h1>Add Course</h1>
            </div>
            <form action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
                <!-- Date Field -->
                <div class="form-group">
                    <div class="form-input">
                        <input 
                            type="hidden" 
                            id="AdminID"
                            name="AdminID" 
                            value="{{ $id }}"
                            required
                            disabled
                        >
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Course Name</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="text" 
                            id="Name" 
                            name="Name"
                            placeholder="Add the Course Name"  
                            value="{{ old('Name') ?? $courses->Name ?? '' }}" 
                            required
                        >
                        @error('Name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Course Description</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="text" 
                            id="Description" 
                            name="Description"" 
                            placeholder="Add the Course Description"
                            value="{{ old('Description') ?? $courses->Description ?? '' }}" 
                            required
                        >
                        @error('Description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Course Price</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="text" 
                            id="Price" 
                            name="Price"
                            placeholder="Add the Course Price"
                            value="{{ old('Price') ?? $courses->Price ?? '' }}" 
                            required
                        >
                        @error('Price')
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
