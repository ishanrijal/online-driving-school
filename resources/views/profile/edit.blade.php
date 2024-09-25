@php
// Determine the role based on the user type
if ($data->user->role == 'admin' || $data->user->role == 'superadmin') {
    $role = 'admin';
    $actionRoute = route('admin.instructor.update', $data->InstructorID);
} elseif ($data->user->role == 'instructor') {
    $role = 'instructor';
    $actionRoute = route('instructor.update', $data->InstructorID);
} elseif ($data->user->role == 'staff') {
    $role = 'staff';
    $actionRoute = route('admin.staff.update', $data->StaffID);
} else {
    $role = 'student';
    $actionRoute = route('admin.student.update', $data->StudentID);
}

$fields = [
    [
        'label'       => 'Name',
        'name'        => 'name',
        'type'        => 'text',
        'id'          => 'name',
        'placeholder' => 'Enter Name',
        'default'     => old('Name', $data->Name),
        'required'    => true,
        'disabled'    => false
    ],
    [
        'label'       => 'Address',
        'name'        => 'Address',
        'type'        => 'text',
        'id'          => 'address',
        'placeholder' => 'Enter Address',
        'default'     => old('Address', $data->Address),
        'required'    => false,
        'disabled'    => false
    ],
    [
        'label'       => 'Date of Birth',
        'name'        => 'DateOfBirth',
        'type'        => 'date',
        'id'          => 'dob',
        'placeholder' => '',
        'default'     => old('DateOfBirth', $data->DateOfBirth), // Corrected here
        'required'    => false,
        'disabled'    => false
    ],
    [
        'label'       => 'Gender',
        'name'        => 'Gender',
        'type'        => 'text', // Corrected to 'text'
        'id'          => 'gender',
        'placeholder' => '',
        'default'     => old('Gender', $data->Gender),
        'required'    => false,
        'disabled'    => false
    ],
    [
        'label'       => 'Contact Number',
        'name'        => 'Phone',
        'type'        => 'text',
        'id'          => 'contact-number',
        'placeholder' => 'Enter Contact Number',
        'default'     => old('Phone', $data->Phone),
        'required'    => false,
        'disabled'    => false
    ],
    [
        'label'       => 'Email',
        'name'        => 'email',
        'type'        => 'email',
        'id'          => 'email',
        'placeholder' => 'Enter Email',
        'default'     => old('email', $user_email),
        'required'    => false,
        'disabled'    => true
    ],
];

@endphp

@extends($role . '.layout') {{-- Corrected here --}}
@section('title', 'Profile')
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

        <x-create-form-component 
            actionName="Edit" 
            actionType="update"
            entity="Profile"
            :resetButton=false
            :imageUploader=true 
            :action="$actionRoute"
            :fields="$fields" 
        /> 
       
    </div>
@endsection
