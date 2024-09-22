@php
    $fields = [
        [
            'label'       => 'Date',
            'name'        => 'Date',
            'type'        => 'date',
            'id'          => 'Date',
            'placeholder' => '',
            'default'     => old('Date', $schedule->Date ?? ''),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Time',
            'name'        => 'Time',
            'type'        => 'time',
            'id'          => 'Time',
            'placeholder' => '',
            'default'     => old('Time', $schedule->Time ?? ''),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Location',
            'name'        => 'Location',
            'type'        => 'text',
            'id'          => 'Location',
            'placeholder' => 'Enter Location',
            'default'     => old('Location', $schedule->Location ?? ''),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Instructor',
            'name'        => 'InstructorID',
            'type'        => 'select',
            'id'          => 'InstructorID',
            'options'     => $instructors,
            'optionKey'   => 'InstructorID',
            'optionValue' => 'Name',
            'placeholder' => 'Select Instructor',
            'default'     => old('InstructorID', $schedule->InstructorID ?? ''),
            'required'    => true,
            'disabled'    => false,
            'options'     => $instructors->pluck('Name', 'InstructorID')->toArray()
       
        ],
        [
            'label'       => 'Course',
            'name'        => 'CourseID',
            'type'        => 'select',
            'id'          => 'CourseID',
            'options'     => $courses,
            'optionKey'   => 'CourseID',
            'optionValue' => 'Name',
            'placeholder' => 'Select Course',
            'default'     => old('CourseID', $schedule->CourseID ?? ''),
            'required'    => true,
            'disabled'    => false,
            'options'     => $courses->pluck('Name', 'CourseID')->toArray()
        ],
        [
            'label'       => 'Student',
            'name'        => 'StudentID',
            'type'        => 'select',
            'id'          => 'StudentID',
            'options'     => $students,
            'optionKey'   => 'StudentID',
            'optionValue' => 'Name',
            'placeholder' => 'Choose Student',
            'default'     => old('StudentID', $schedule->StudentID ?? ''),
            'required'    => true,
            'disabled'    => false,
            'options'     => $students->pluck('Name', 'StudentID')->toArray()
        ],
    ];
@endphp

@extends('admin.layout')

@section('title', 'Edit Class Schedule')

@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="Schedule For {{$schedule->student->Name ?? ''}}"
            :resetButton=false 
            :imageUploader=false 
            :action="route('admin.classSchedule.update', $schedule->ClassScheduleID )" 
            :fields="$fields" 
        />
    </div>
@endsection
