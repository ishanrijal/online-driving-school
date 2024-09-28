@php
// Determine the role based on the user type
if ($data->user->role == 'admin' || $data->user->role == 'superadmin') {
    $role = 'admin';
    $actionRoute = route('admin.profile.update', $data->AdminID);
} elseif ($data->user->role == 'instructor') {
    $role = 'instructor';
    $actionRoute = route('instructor.update', $data->InstructorID);
} elseif ($data->user->role == 'staff') {
    $role = 'staff';
    $actionRoute = route('staff.profile.update', $data->StaffID);
} else {
    $role = 'student';
    $actionRoute = route('admin.student.update', $data->StudentID);
}
$fields = [];

    $fields[] = [
        'label'       => 'Name',
        'name'        => 'Name',
        'type'        => 'text',
        'id'          => 'Name',
        'placeholder' => 'Enter Name',
        'default'     => old('Name', $data->user->name),
        'required'    => true,
        'disabled'    => false
    ];
    
    // Conditionally add fields based on the role
    if ($role !== 'admin') {
        $fields[] = [
            'label'       => 'Address',
            'name'        => 'Address',
            'type'        => 'text',
            'id'          => 'address',
            'placeholder' => 'Enter Address',
            'default'     => old('Address', $data->Address),
            'required'    => false,
            'disabled'    => false
        ];

        $fields[] = [
            'label'       => 'Date of Birth',
            'name'        => 'DateOfBirth',
            'type'        => 'date',
            'id'          => 'dob',
            'placeholder' => '',
            'default'     => old('DateOfBirth', $data->DateOfBirth), // Corrected
            'required'    => false,
            'disabled'    => false
        ];

        $fields[] = [
            'label'       => 'Gender',
            'name'        => 'Gender',
            'type'        => 'text', // Corrected
            'id'          => 'gender',
            'placeholder' => 'male',
            'default'     => old('Gender', $data->Gender),
            'required'    => false,
            'disabled'    => false
        ];

        $fields[] = [
            'label'       => 'Contact Number',
            'name'        => 'Phone',
            'type'        => 'text',
            'id'          => 'contact-number',
            'placeholder' => 'Enter Contact Number',
            'default'     => old('Phone', $data->Phone),
            'required'    => false,
            'disabled'    => false
        ];
    }
    $fields[] = [
        'label'       => 'Email',
        'name'        => 'email',
        'type'        => 'email',
        'id'          => 'email',
        'placeholder' => 'Enter Email',
        'default'     => old('email', $user_email),
        'required'    => false,
        'disabled'    => true
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
