@php
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
            :action="route('admin.course.update', $course->CourseID)" 
            :fields="$fields" 
        />
    </div>
@endsection