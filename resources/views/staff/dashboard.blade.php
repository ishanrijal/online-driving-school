@extends('staff.layout')
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
                                    <h4>Month Revenue</h4>
                                    <h2>$90k</h2>
                                    <p>March 2023</p>
                                    <span class="change positive">+ 37.43%</span>
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
                                    <p>Aug 13 - Sep 13</p>
                                    <span class="change positive">+ 37.43%</span>
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
                                    <span class="change negative">- 13.43%</span>
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
                                    <span class="see-all-text">See All</span>
                                    <img src="{{ asset('assets/svgs/right-arrow.svg') }}" />
                                </div>
                            </div>
                            
                            <div class="sales-data">
                                <article class="sales-item">
                                    <div class="sales-content">
                                        <div class="sales-text">
                                            <h3 class="sales-period">This Year</h3>
                                            <p class="sales-amount">Rs.10,000</p>
                                        </div>
                                        <div class="sales-icon">
                                            <img src="{{ asset('assets/svgs/sale-up.svg') }}" alt="Sales graph for this year"/>
                                            <span>3.5%</span>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                </article>
                                <article class="sales-item">
                                    <div class="sales-content">
                                        <div class="sales-text">
                                            <h3 class="sales-period">This Year</h3>
                                            <p class="sales-amount">Rs.10,000</p>
                                        </div>
                                        <div class="sales-icon">
                                            <img src="{{ asset('assets/svgs/sale-up.svg') }}" alt="Sales graph for this year"/>
                                            <span>3.5%</span>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                </article>
                                <article class="sales-item">
                                    <div class="sales-content">
                                        <div class="sales-text">
                                            <h3 class="sales-period">This Year</h3>
                                            <p class="sales-amount">Rs.10,000</p>
                                        </div>
                                        <div class="sales-icon">
                                            <img src="{{ asset('assets/svgs/sale-down.svg') }}" alt="Sales graph for this year"/>
                                            <span>3.5%</span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>
                    </div>

                    <div class="col-sm-4">
                        <section class="income-container">
                            <div class="income-header">
                                <h2 class="income-title">Registration Record</h2>
                            </div>
                            <div class="sales-data">
                                <canvas id="registrationBarChart" width="400" height="400"></canvas>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection