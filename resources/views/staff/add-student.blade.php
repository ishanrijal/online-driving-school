@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $addRoute = route('admin.student.store');
    }  else{
        $role = 'staff';
        $addRoute = route('staff.student.store');
    }
    $fields = [
        [
            'label'       => 'Name',
            'name'        => 'name',
            'type'        => 'text',
            'id'          => 'name',
            'placeholder' => 'Enter Name',
            'default'     => old('name', ''), // Use old value if available, otherwise empty
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Email Address',
            'name'        => 'email',
            'type'        => 'email',
            'id'          => 'email',
            'placeholder' => 'email@email.com',
            'default'     => old('email', ''), // Use old value if available, otherwise empty
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Role',
            'name'        => 'role_disabled',
            'type'        => 'text',
            'id'          => 'role',
            'placeholder' => '',
            'default'     => old('role_disabled', 'Student'), // Use old value if available, otherwise 'Student'
            'required'    => false,
            'disabled'    => true
        ],
    ];
@endphp

@extends($role. '.layout')
@section('title', 'Add Student')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Add" 
            actionType="add"
            entity="Student"
            :resetButton=false
            :imageUploader=false 
            :action="$addRoute" 
            :fields="$fields" 
        />
    </div>
@endsection


{{-- actionName="Add" entity="Trainer" 
:action="route('admin.instructor.store')" 
:fields="$fields"  --}}