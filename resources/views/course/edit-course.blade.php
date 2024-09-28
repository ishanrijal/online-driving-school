@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $actionRoute = 'admin.course.update';
        // $addRoute = route('admin.course.create');
    }  else {
        $role = 'staff';
        $actionRoute = 'staff.course.update';
        // $addRoute = route('staff.course.create');
        // $actionRoute = route('admin.staff.update', $StaffID);
    }
    $fields = [
        [
            'label'       => 'Course Name',
            'name'        => 'Name',
            'type'        => 'text',
            'id'          => 'Name',
            'placeholder' => 'Course Name',
            'default'     => old('Name', $course->Name),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Course Description',
            'name'        => 'Description',
            'type'        => 'text',
            'id'          => 'Description',
            'placeholder' => 'Course Description',
            'default'     => old('Description', $course->Description),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Course Price',
            'name'        => 'Price',
            'type'        => 'text',
            'id'          => 'Price',
            'placeholder' => 'Course Price',
            'default'     => old('Price', $course->Price),
            'required'    => true,
            'disabled'    => false
        ],
    ];
@endphp
@extends('admin.layout')
@section('title', 'Edit Payment')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="{{$course->CourseID}}"
            :resetButton=false 
            :imageUploader=false 
            :action="route($actionRoute, $course->CourseID)" 
            :fields="$fields" 
        />
    </div>
@endsection