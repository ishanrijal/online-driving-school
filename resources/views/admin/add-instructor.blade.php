@php
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => '',
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Email Address',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => 'email@email.com',
            'default'     => '',
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'role',
            'name'        => 'role_disabled',
            'type'        => 'text',
            'id'          => 'role',
            'placeholder' => '',
            'default'     => 'instructor',
            'required'    => false,
            'disabled'    => true
        ],
    ];
@endphp

@extends('admin.layout')
@section('title', 'Add Instructor')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Add" 
            actionType="add"
            entity="Instructor"
            :resetButton=false
            :imageUploader=false 
            :action="route('admin.instructor.store')" 
            :fields="$fields" 
        />
    </div>
@endsection