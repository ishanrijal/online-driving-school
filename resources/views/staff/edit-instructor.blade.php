@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $actionRoute = route('admin.instructor.update', $instructor->InstructorID);
    } else {
        $role = 'staff';
        $actionRoute = route('staff.instructor.update', $instructor->InstructorID);
    }
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => old('name', $instructor->Name),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Contact Number',
            'name'        => 'Phone',
            'type'        => 'text',
            'id'          => 'contact-number',
            'placeholder' => 'Enter Contact Number',
            'default'     => old('Phone', $instructor->Phone),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'License Number',
            'name'        => 'LicenseNumber',
            'type'        => 'text',
            'id'          => 'licenseNumber',
            'placeholder' => 'Enter License Number',
            'default'     => old('LicenseNumber', $instructor->LicenseNumber),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Email',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => '',
            'default'     => $instructor->user->email,
            'required'    => false,
            'disabled'    => true
        ],
    ];
@endphp
@extends('staff.layout')
@section('title', 'Edit Trainer')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="Instructor"
            :resetButton=false 
            :imageUploader=false 
            :action="$actionRoute" 
            :fields="$fields" 
        />
    </div>
@endsection