@php
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => old('name'),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Email Address',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => 'email@email.com',
            'default'     => old('email'),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Role',
            'name'        => 'role',
            'type'        => 'select',
            'id'          => 'role',
            'placeholder' => '',
            'default'     => 'Staff',
            'required'    => false,
            'disabled'    => false,
            'options'     => [
                'staff' => 'Staff',
                'admin' => 'Admin',
            ]
        ],
    ];
@endphp

@extends('admin.layout')
@section('title', 'Add Staff')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Add" 
            actionType="add"
            entity="Staff"
            :resetButton=false
            :imageUploader=false 
            :action="route('admin.staff.store')" 
            :fields="$fields" 
        />
    </div>
@endsection