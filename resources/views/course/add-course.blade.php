@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $id = $user->admin->id;
        $actionRoute = route('admin.invoice.store');
    } else {
        $role = 'staff';
        dd($user->admin);
        $actionRoute = route('staff.invoice.store');
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
            <form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
                <!-- Date Field -->
                <div class="form-group">
                    <div class="label-container">
                        <label for="date">Course Added By</label>
                    </div>
                    <div class="form-input">
                        <input 
                            type="number" 
                            id="AdminID"
                            name="AdminID" 
                            value="{{ auth()->user()->admin->AdminID }}"
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
