@extends('student.layout')
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
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title" style="text-align: center">Available Course</h2>
            </div>
            <div class="col-sm-12 program-card-container course-purchase">
                @if($courses->isEmpty())
                    <div class="alert alert-danger">
                        No courses available.
                    </div>
                @else
                    @foreach ( $courses as $course )
                        <div class="card">
                            <img class="card-img-top" src="https://lirp.cdn-website.com/5d723f7de664428fab6c1e09200b20d1/dms3rep/multi/opt/709-376w.jpg" alt="Card image cap">
                            <div class="card-body">
                                <div class="course-card-header">
                                    <h2 class="course-title">{{$course->Name}}</h2>
                                    <p class="course-price mb-2 text-muted">$.{{$course->Price}}</p>
                                </div>
                                <p class="card-description" style="font-weight: 700">{{$course->Description}}</p>

                                @if( $course->enroll_status )
                                    <a href="{{ route('payment.show', $course->CourseID) }}" class="btn btn-primary">
                                        Unenroll
                                    </a>
                                @else
                                    <a href="{{ route('payment.show', $course->CourseID) }}" class="btn btn-primary">
                                        Enroll Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection