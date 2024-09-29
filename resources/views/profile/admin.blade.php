@extends('admin.layout')
@section('title', 'Profile')
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
        <div class="container mt-4 profile-container">
          <div class="col-sm-8 card box-shadow">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                  @if($staff && $staff->image)
                      <img src="{{ asset('storage/' . $staff->image) }}" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                  @else
                      <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                  @endif
                  <div class="mt-3">
                    @if( $staff->AdminRole == 'superadmin')
                      <h4 style="text-transform: capitalize">{{$staff->user->name}}</h4>
                    @elseif( $staff->AdminID & is_null($staff->user_id) )
                      <h4 style="text-transform: capitalize">{{ $staff->Name ?? 'Admin' }}</h4>
                    @endif
                    <p class="text-muted font-size-sm">Origin Driving School</p>

                    <div class="action-btn">
                        <form action="{{ route('logout') }}" method="post">
                          @csrf
                          <button type="submit" class="btn btn-primary btn-block">Logout</button>
                      </form>   
                      <a class="btn btn-info" href="{{ route('profile.edit') }}">Edit</a>                    
                    </div>
                  </div>
                </div>
              </div>
          </div>
          @if( !( $staff->AdminRole == 'superadmin') )
            <div class="col-md-8 box-shadow">
              <div class="card mb-3">
                <div class="card-body">
                  @if( $staff->Name )
                      <div class="row">
                          <div class="col-sm-3">
                              <h6 class="mb-0">Full Name</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              {{ $staff->Name }}
                          </div>
                      </div>
                      <hr>
                  @endif
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$user_email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    {{-- {{dd($staff)}} --}}
                    <div class="col-sm-9 text-secondary">
                      {{$staff->Gender ?? '-' }}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date Of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$staff->DateOfBirth ?? '-' }}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{ $staff->Phone ?? "-" }}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{ $staff->Address ?? "-" }}
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
          @endif             
      </div>
    </div>
@endsection