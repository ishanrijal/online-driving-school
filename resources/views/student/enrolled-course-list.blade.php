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
                <section class="purchases box-shadow">
                    <div class="table-top">
                        <h2 class="title">Enrolled Courses</h2>
                        <div class="search-bar">
                            <input type="text" id="search-input" placeholder="Search Class Schedule">
                            <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
                        </div>
                    </div>
                    @if($classSchedules->isEmpty())
                        <div class="alert alert-info">
                            You are not enrolled into any courses.
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Course Description</th>
                                    <th>Price</th>
                                    <th>Course Enroll Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="appointments-body">
                                @foreach ( $classSchedules as $class )
                                {{-- {{dd($class->course->created_at)}} --}}
                                    <tr class="class-row">
                                        <td>{{$class->course->Name}}</td>
                                        <td>{{$class->course->Description}}</td>
                                        <td>{{$class->course->Price}}</td>
                                        <td>{{ $class->course->created_at->format('d F Y') }}</td>
                                        <td class="action-btn actions-container">            
                                            <form action="#" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure you want to delete?');">
                                                    Unenroll
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection