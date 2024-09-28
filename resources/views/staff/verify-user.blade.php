@extends('staff.layout')
@section('title', 'Verify User')
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
            <h3>User Waiting For Verification: <span class="entity-count">{{ $users->total() }}</span></h3>
        </div>

        @if( $users->total() > 0 )
            <table>
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>    
                        
                        <td class="action-btn actions-container">
                            <form action="{{ route('staff.user.verify', $user->user_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="verify-btn btn btn-primary">
                                    Verify
                                </button>
                            </form>
                        
                            <form action="{{ route('staff.instructor.destroy', $user->user_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete {{ strtolower($user->name) }}?');">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                
                </tbody>
            </table>
        @else
            <div class="alert alert-info" style="margin-top:50px">
                <h5 style="text-align: center; margin-bottom:0;font-weight:700">No New Users</h5>
            </div>
        @endif
        <!-- Use the pagination component -->
        <x-pagination :paginator="$users" />
    </div>
@endsection