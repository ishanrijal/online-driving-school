@php
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
            'default'     => old('role_disabled', 'instructor'), // Use old value if available, otherwise 'instructor'
            'required'    => false,
            'disabled'    => true
        ],
    ];


    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $actionRoute = route('admin.instructor.store');
    } else {
        $role = 'staff';
        $actionRoute = route('staff.instructor.store');
    }
@endphp

@extends($role.'.layout')
@section('title', 'Add Instructor')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Add" 
            actionType="add"
            entity="Instructor"
            :resetButton=false
            :imageUploader=false 
            :action="$actionRoute" 
            :fields="$fields" 
        />
    </div>
@endsection