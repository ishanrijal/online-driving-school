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
            <h3>Total students: <span class="entity-count">{{ $staffs->total() }}</span></h3>
            <div class="actions-container">
                <a href="staff/create"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add staffs</a>
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
                @foreach($staffs as $staff)
                <tr>
                    <td>{{ ($staffs->currentPage() - 1) * $staffs->perPage() + $loop->iteration }}</td>
                    <td>{{ $staff->Name }}</td>
                    <td>{{ $staff->Address }}</td>
                    <td>{{ $staff->DateOfBirth }}</td>                    
                    <td>{{ $staff->Gender }}</td>                    
                    <td>{{ $staff->Phone }}</td>                    
                    <td class="action-btn">
                        <a href="{{ route('admin.staff.edit', $staff->StaffID) }}">
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ route('admin.staff.destroy', $staff->StaffID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this {{ strtolower($staff->Name) }}?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>

        <!-- Use the pagination component -->
        <x-pagination :paginator="$staffs" />
    </div>
@endsection