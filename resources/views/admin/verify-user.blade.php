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
            <h3>Total Users: <span class="entity-count">{{ $users->total() }}</span></h3>
        </div>

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
                        <form action="{{ route('admin.user.verify', $user->user_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="verify-btn btn">
                                Verify
                            </button>
                        </form>
                    
                        <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this {{ strtolower($user->name) }}?');">
                                Remove
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>

        <!-- Use the pagination component -->
        <x-pagination :paginator="$users" />
    </div>
@endsection