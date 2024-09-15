@extends('admin.layout')
@section('title', 'Trainer')
@section('content')
    <x-entity-table 
        :entities="$instructors" 
        entityName="Instructors"
        column1="Name"
        column2="License Number"
        column3="Contact No"
        field1="Name"
        field2="LicenseNumber"
        field3="Phone"
        createRoute="instructor/create"
        editRoute="admin.instructor.edit"
        deleteRoute="admin.instructor.destroy"
    />
@endsection
