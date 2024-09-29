@php
// Determine the role based on the user type
$staff_admin = false;
$image_uploader = true;
$actionRoute='';
if ( $data->user && $data->user->role == 'superadmin') {
    $role = 'admin';
    $actionRoute = route('admin.profile.update', $data->AdminID);
    $image_uploader = false;
} elseif( $data->AdminID && is_null($data->user_id) ){
    $role = 'admin';
    $staff_admin = true;
    $actionRoute = route('admin.profile.update', $data->AdminID);
    $image_uploader = false;
}elseif ($data->user->role == 'instructor') {
    $role = 'instructor';
    $actionRoute = route('instructor.profileupdate', $data->InstructorID);
} elseif ($data->user->role == 'staff') {
    $role = 'staff';
    $actionRoute = route('staff.profile.update', $data->StaffID);
} else {
    $role = 'student';
    $actionRoute = route('student.profile.update', $data->StudentID);
}
$fields = [];

    if( ! $staff_admin ){
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
    }else{
        // for admin role only
        $fields[] = [
            'label'       => 'Name',
            'name'        => 'Name',
            'type'        => 'text',
            'id'          => 'Name',
            'placeholder' => 'Enter Name',
            'default'     => old('Name', $data->Name),
            'required'    => true,
            'disabled'    => false
        ];
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

        $fields[]=[
            'label'       => 'Gender',
            'name'        => 'Gender',
            'type'        => 'select',
            'id'          => 'Gender',
            'placeholder' => '',
            'default'     => old('Gender', $data->Gender),
            'required'    => false,
            'disabled'    => false,
            'options'     => [
                'male' => 'Male',
                'female' => 'Female',
                'other' => 'Others',
            ]
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

@extends($role . '.layout')
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
            :imageUploader=$image_uploader
            :action="$actionRoute"
            :fields="$fields" 
        /> 
       
    </div>
@endsection
