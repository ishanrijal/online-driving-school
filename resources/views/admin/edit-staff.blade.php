@php
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'Name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => old('Name', $staff->Name),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Address',
            'name'        => 'Address',
            'type'        => 'text',
            'id'          => 'address',
            'placeholder' => 'Enter Address',
            'default'     => old('Address', $staff->Address),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Date of Birth',
            'name'        => 'DateOfBirth',
            'type'        => 'date',
            'id'          => 'dob',
            'placeholder' => '',
            'default'     => old('DateOfBirth', $staff->Address),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Gender',
            'name'        => 'Gender',
            'type'        => 'type',
            'id'          => 'gender',
            'placeholder' => '',
            'default'     => old('Gender', $staff->Gender),
            'required'    => false,
            'disabled'    => false
        ],
        [
            'label'       => 'Contact Number',
            'name'        => 'Phone',
            'type'        => 'text',
            'id'          => 'contact-number',
            'placeholder' => 'Enter Contact Number',
            'default'     => old('Phone', $staff->Phone),
            'required'    => false,
            'disabled'    => false
        ],
    ];
@endphp

@extends('admin.layout')
@section('title', 'Edit Trainer')
@section('content')
    <x-create-form-component 
        actionName="Edit" 
        actionType="update"
        entity="staff"
        :resetButton=false 
        :imageUploader=false 
        :action="route('admin.staff.update', $staff->StaffID)" 
        :fields="$fields" 
    />
@endsection