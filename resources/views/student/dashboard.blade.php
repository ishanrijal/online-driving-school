@extends('student.layout')
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
                    <div class="col-sm-12" style="margin-top:24px ">
                        <h1> <b>Welcome to the dashboard <span class="alert alert-info">{{ $data['student']->Name }}</span> </b></h1>
                    </div>
                    <div class="row" style="margin-top: 48px; gap:48px">
                        <div class="col-sm-4">
                            <div class="dashboard-card">
                                <div class="students-header">
                                  <h2 class="students-title">Class Counts</h2>
                                  <div class="count-wrapper">
                                    @if($appointments->count() > 0)
                                        {{$appointments->count()}}
                                    @else
                                        0
                                    @endif
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="dashboard-card">
                                <div class="students-header">
                                  <h2 class="students-title">Unpaid Invoice</h2>
                                  <div class="count-wrapper">
                                    @if($invoices->count() > 0)
                                        {{$invoices->count()}}
                                    @else
                                        0
                                    @endif
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection