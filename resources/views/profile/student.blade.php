@extends('student.layout')
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
      <div class="container mt-4" style="display: flex;flex-direction:column;justify-content:center;align-items:center">
          <div class="col-sm-8 card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                  @if($staff && $staff->image)
                  {{-- {{dd($staff->image)}} --}}
                      <img src="{{ asset('storage/' . $staff->image) }}" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                  @else
                      <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                  @endif
                  <div class="mt-3">
                    <h4>{{ $staff->Name ?? 'No Name' }}</h4>
                    {{-- <p class="text-secondary mb-1">Full Stack Developer</p>
                    <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                    <button class="btn btn-primary">Follow</button>
                    <button class="btn btn-outline-primary">Message</button> --}}
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-8">
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
                  <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info" href="">Edit</a>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
@endsection