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
                    <div class="col-sm-12">
                        <h1> <b>Welcome to the dashboard </b></h1>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection