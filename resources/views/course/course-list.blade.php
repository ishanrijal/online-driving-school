@php
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $addRoute = route('admin.course.create');
        // $actionRoute = route('admin.profile.update', $AdminID);
    } elseif ($user->role == 'instructor') {
        $role = 'instructor';
        // $actionRoute = route('instructor.update', $InstructorID);
    } elseif ($user->role == 'staff') {
        $role = 'staff';
        $addRoute = route('staff.course.create');
        // $actionRoute = route('admin.staff.update', $StaffID);
    } else {
        $role = 'student';
        // $actionRoute = route('admin.student.update', $StudentID);
    }
@endphp

@extends($role. '.layout')
@section('title', 'Invoices')
@section('content')
    <div class="content-wrapper">
        @if(session('success'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="header">
            <h3>Total Courses: <span class="entity-count">{{ $courses->count() }}</span></h3>
            <div class="actions-container">
                <a href="{{ $addRoute }}">
                    <img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add Course
                </a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Price</th>
                    <th>Added By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $course->Name }}</td>
                    <td>{{ $course->Description }}</td>
                    <td>{{ $course->Price }}</td>                    
                    <td>{{ $course->AdminID ? "Admin" : 'Staff' }}</td>
                    <td class="action-btn">
                        <a href="{{ ($user->role == 'staff') ?  route('staff.course.edit', $course->CourseID) :  route('admin.course.edit', $course->CourseID) }}"> 
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ ($user->role == 'staff') ? route('staff.course.destroy', $course->CourseID) : route('admin.course.destroy', $course->CourseID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn btn btn-primary" type="submit" onclick="return confirm('Are you sure you want to delete this course?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Optional pagination, if using paginate -->
        @if(method_exists($courses, 'links'))
            <x-pagination :paginator="$courses" />
        @endif
    </div>
@endsection