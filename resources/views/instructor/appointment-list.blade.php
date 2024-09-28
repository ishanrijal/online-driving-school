@extends('instructor.layout')
@section('title', 'Appointment List')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @if (session('success'))
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
    </div>
</div>
<div class="row">
    @if(!$appointments->isEmpty())
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Student Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->student->Name }}</td>
                    <td>{{ $appointment->Date }}</td>
                    <td>{{ $appointment->Time }}</td>                    
                    <td>{{ $appointment->Location }}</td>                    
                    <td>{{ $appointment->Course->Name }}</td>       
                    <td class="action-btn actions-container">
                        <form action="{{ route('instructor.status-confirm', $appointment->ClassScheduleID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="verify-btn btn btn-primary">
                                Confirm
                            </button>
                        </form>
                        <form action="{{ route('instructor.status.cancel', $appointment->ClassScheduleID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="verify-btn btn btn-secondary" style="background: var(--primary)">
                                Cancel
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <h3>No Appointments Available</h3>
        </div>
    @endif
</div>
@endsection
