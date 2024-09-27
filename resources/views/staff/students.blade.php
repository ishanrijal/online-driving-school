@extends('admin.layout')
@section('title', 'Trainer')
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
            <h3>Total students: <span class="entity-count">{{ $students->total() }}</span></h3>
            <div class="actions-container">
                <a href="student/create"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add students</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Date Of Birth</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                    <td>{{ $student->Name }}</td>
                    <td>{{ $student->Address }}</td>
                    <td>{{ $student->DateOfBirth }}</td>                    
                    <td>{{ $student->Gender }}</td>                    
                    <td>{{ $student->Phone }}</td>                    
                    <td class="action-btn">
                        <a href="{{ route('admin.student.edit', $student->StudentID) }}">
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ route('admin.student.destroy', $student->StudentID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this {{ strtolower($student->Name) }}?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>

        <!-- Use the pagination component -->
        <x-pagination :paginator="$students" />
    </div>
@endsection