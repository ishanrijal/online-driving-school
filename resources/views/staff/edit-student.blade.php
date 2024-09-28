@php
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'Name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => old('Name', $student->Name),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Address',
            'name'        => 'Address',
            'type'        => 'text',
            'id'          => 'address',
            'placeholder' => 'Enter Address',
            'default'     => old('Address', $student->Address),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Date of Birth',
            'name'        => 'DateOfBirth',
            'type'        => 'date',
            'id'          => 'dob',
            'placeholder' => '',
            'default'     => old('DateOfBirth', $student->Address),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Gender',
            'name'        => 'Gender',
            'type'        => 'type',
            'id'          => 'gender',
            'placeholder' => '',
            'default'     => old('Gender', $student->Gender),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Contact Number',
            'name'        => 'Phone',
            'type'        => 'text',
            'id'          => 'contact-number',
            'placeholder' => 'Enter Contact Number',
            'default'     => old('Phone', $student->Phone),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Email',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => '',
            'default'     => $student->user->email,
            'required'    => true,
            'disabled'    => true
        ],
    ];

    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $updateRoute = route('admin.student.update', $student->StudentID);
    }  else{
        $role = 'staff';
        $updateRoute = route('staff.student.update', $student->StudentID);
    }
@endphp

@extends($role. '.layout')
@section('title', 'Edit Trainer')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit" 
            actionType="update"
            entity="student"
            :resetButton=false 
            :imageUploader=false 
            :action="$updateRoute" 
            :fields="$fields" 
        />
    </div>
@endsection