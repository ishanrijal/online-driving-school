@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <section class="content">
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
                              <img src="{{ asset('assets/svgs/user.svg') }}" alt="" class="students-icon" />
                            </div>
                            <div class="students-divider" role="separator"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <div class="students-header">
                              <h2 class="students-title">Vehicles</h2>
                              <img src="{{ asset('assets/svgs/vehicle.svg') }}" alt="" class="students-icon" />
                            </div>
                            <div class="students-divider" role="separator"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dashboard-card">
                            <div class="students-header">
                              <h2 class="students-title">Staff</h2>
                              <img src="{{ asset('assets/svgs/user.svg') }}" alt="" class="students-icon" />
                            </div>
                            <div class="students-divider" role="separator"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                </div>
            </div>
        </section>
    </div>
@endsection