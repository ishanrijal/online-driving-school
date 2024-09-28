@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        // $actionRoute = route('admin.invoice.store');
    } else {
        $role = 'staff';
        // $actionRoute = route('staff.invoice.store');
    }
@endphp

@extends($role.'.layout')
@section('title', 'Instructor')
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
            <h3>Total Instructors: <span class="entity-count">{{ $instructors->total() }}</span></h3>
            <div class="actions-container">
                <a href="instructor/create"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add Instructors</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>License Number</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($instructors as $instructor)
                <tr>
                    <td>{{ ($instructors->currentPage() - 1) * $instructors->perPage() + $loop->iteration }}</td>
                    <td>{{ $instructor->Name }}</td>
                    <td>{{ $instructor->LicenseNumber }}</td>
                    <td>{{ $instructor->Phone }}</td>    
                    
                    @if ($instructor->user->hasVerifiedEmail())
                        <td class="action-btn">
                            <a href="{{ $role == 'admin' ? route('admin.instructor.edit', $instructor->InstructorID) : route('staff.instructor.edit', $instructor->InstructorID) }}">
                                <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                            </a>
                            <form action="{{ $role == 'admin' ? route('admin.instructor.destroy', $instructor->InstructorID) : route('staff.instructor.destroy', $instructor->InstructorID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this {{ strtolower($instructor->Name) }}?');">
                                    <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                                </button>
                            </form>
                        </td>                       
                    @else
                        <td class="action-btn actions-container">
                            <form action="{{ route('admin.user.verify', $instructor->user->user_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="verify-btn btn">
                                    Verify
                                </button>
                            </form>

                            <form action="{{ route('admin.instructor.destroy', $instructor->InstructorID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete {{ strtolower($instructor->Name) }}?');">
                                    Remove
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
                @endforeach
               
            </tbody>
        </table>

        <!-- Use the pagination component -->
        <x-pagination :paginator="$instructors" />
    </div>
@endsection