@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <section class="content" style="margin-top: 24px">
            <div class="container-fluid">
                <div class="row">
                    @if (session('success'))
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    <div class="row dashboard-insight">
                        <h2 class="title">Overview</h2>
                        <div class="col-sm-12">
                            <section class="overview">
                                <div class="card">
                                    <h4>Total Revenue</h4>
                                    <h2>
                                        @if(session('total_invoice') > 0)
                                            $.{{session('total_invoice')}}
                                        @else
                                            $.0
                                        @endif
                                    </h2>
                                    <p>{{ date('F Y') }}</p>
                                    <span class="change positive">Total Amount Earned</span>
                                </div>
                                <div class="card">
                                    <h4>Total Instructors</h4>
                                    <h2>
                                        @if(session('instructors_count') > 0)
                                            {{session('instructors_count')}}
                                        @else
                                            0
                                        @endif
                                    </h2>
                                    <p>{{ date('F Y') }}</p>
                                    <span class="change positive">Total Instructor Count</span>
                                </div>
                                <div class="card">
                                    <h4>Total Students</h4>
                                    <h2>
                                        @if(session('students_count')> 0)
                                            {{session('students_count')}}
                                            @else
                                            0
                                        @endif
                                    </h2>
                                    <p>{{ date('F Y') }}</p>
                                    <span class="change negative">Total Enrolled Student</span>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 64px">
                    <div class="col-sm-4">
                        <section class="income-container">
                        <div class="income-header">
                                <h2 class="income-title">Registration Record</h2>
                            </div>
                            <div class="sales-data">
                                <canvas id="entityPieChart" width="400" height="400"></canvas>
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-4">
                        <section class="income-container">
                            <div class="income-header">
                                <h2 class="income-title">Income</h2>
                                <div class="see-all-wrapper">
                                    <a href="{{route('admin.invoice.index')}}" class="see-all-text">
                                        <span>See All</span>
                                        <img src="{{ asset('assets/svgs/right-arrow.svg') }}" />
                                    </a>
                                </div>
                            </div>
                            
                            <div class="sales-data">
                                @foreach ( $data['invoices'] as $invoice )                                    
                                    <article class="sales-item">
                                        <div class="sales-content">
                                            <div class="sales-text">
                                                <h3 class="sales-period">{{ date('d F, Y', strtotime($invoice->Date)) }}</h3>
                                                <p class="sales-amount">$. {{$invoice->TotalAmount}}</p>
                                            </div>
                                        </div>
                                        @if (!$loop->last) 
                                            <div class="divider"></div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-4">
                        <section class="income-container">
                            <div class="income-header">
                                <h2 class="income-title">Course List</h2>
                                <div class="see-all-wrapper">
                                    <a href="{{route('admin.course.index')}}" class="see-all-text">
                                        <span>See All</span>
                                        <img src="{{ asset('assets/svgs/right-arrow.svg') }}" />
                                    </a>
                                </div>
                            </div>
                            
                            <div class="sales-data">
                                @foreach ( $data['courses'] as $course )                  
                                    <article class="sales-item">
                                        <div class="sales-content">
                                            <div class="sales-text">
                                                <h3 class="sales-period">{{ $course->Name }}</h3>
                                                <p class="sales-amount">$. {{$course->Price}}</p>
                                            </div>
                                        </div>
                                        @if (!$loop->last) 
                                            <div class="divider"></div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection