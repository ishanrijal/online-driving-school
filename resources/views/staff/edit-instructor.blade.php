@php
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
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'License Number',
            'name'        => 'LicenseNumber',
            'type'        => 'text',
            'id'          => 'licenseNumber',
            'placeholder' => 'Enter License Number',
            'default'     => old('LicenseNumber', $instructor->LicenseNumber),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Email',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => '',
            'default'     => $instructor->user->email,
            'required'    => true,
            'disabled'    => true
        ],
    ];
@endphp
@extends('admin.layout')
@section('title', 'Edit Trainer')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="Instructor"
            resetButton=true 
            imageUploader=true 
            :action="route('admin.instructor.update', $instructor->InstructorID)" 
            :fields="$fields" 
        />
    </div>
@endsection