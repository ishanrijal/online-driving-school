@php
    $fields = [
        [
            'label'       => 'Payment Date',
            'name'        => 'Date',
            'type'        => 'date',
            'id'          => 'Date',
            'placeholder' => 'Payment Date',
            'default'     => old('Date', $payment->Date),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Payment Type',
            'name'        => 'Type',
            'type'        => 'Type',
            'id'          => 'Type',
            'placeholder' => '',
            'default'     => old('Type', $payment->Type),
            'required'    => true,
            'disabled'    => false
        ],
    ];
@endphp
@extends('admin.layout')
@section('title', 'Edit Payment')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="{{$payment->PaymentID}}"
            :resetButton=false 
            :imageUploader=false 
            :action="route('admin.payment.update', $payment->PaymentID)" 
            :fields="$fields" 
        />
    </div>
@endsection