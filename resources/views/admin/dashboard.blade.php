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
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <div class="students-header">
                              <h2 class="students-title">Students</h2>
                              <div class="count-wrapper">
                                <h3>{{session('students_count')}}</h3>
                                  <img src="{{ asset('assets/svgs/user.svg') }}" alt="" class="students-icon" />
                              </div>
                            </div>
                            <div class="students-divider" role="separator"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <div class="students-header">
                              <h2 class="students-title">Vehicles</h2>
                              <div class="count-wrapper">
                                <h3>{{session('instructors_count')+2}}</h3>
                                  <img src="{{ asset('assets/svgs/vehicle.svg') }}" alt="" class="students-icon" />
                              </div>
                            </div>
                            <div class="students-divider" role="separator"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <div class="students-header">
                              <h2 class="students-title">Instructors</h2>
                              <div class="count-wrapper">
                                <h3>{{session('instructors_count')}}</h3>
                                  <img src="{{ asset('assets/svgs/user.svg') }}" alt="" class="students-icon" />
                              </div>
                            </div>
                            <div class="students-divider" role="separator"></div>
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