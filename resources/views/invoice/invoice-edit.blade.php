@php
    $fields = [
        [
            'label'       => 'Total Amount',
            'name'        => 'TotalAmount',
            'type'        => 'text',
            'id'          => 'TotalAmount',
            'placeholder' => 'Enter Total Amount',
            'default'     => old('TotalAmount', $invoice->TotalAmount),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Invoice Type',
            'name'        => 'Type',
            'type'        => 'text',
            'id'          => 'Type',
            'placeholder' => 'course fee',
            'default'     => old('Type', $invoice->payments->Type),
            'required'    => true,
            'disabled'    => false
        ],
        [
            'label'       => 'Current Payment Status',
            'name'        => 'CurrentStatus',
            'type'        => 'CurrentStatus',
            'id'          => 'CurrentStatus',
            'placeholder' => '',
            'default'     => old('Status', $invoice->Status),
            'required'    => true,
            'disabled'    => true
        ],
        [
            'label'       => 'Status',
            'name'        => 'Status',
            'type'        => 'select',
            'id'          => 'Status',
            'placeholder' => 'Update Status',
            'default'     => $invoice->Status,
            'required'    => true,
            'disabled'    => false,
            'options'     => [
                'unpaid'     => 'Unpaid',
                'processing' => 'Processing',
                'paid'       => 'Paid',
            ]
        ],
    ];

    //role based layout
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $actionRoute = route('admin.invoice.update', $invoice->InvoiceID);
    } else {
        $role = 'staff';
        $actionRoute = route('staff.invoice.update', $invoice->InvoiceID);
    }
@endphp
@extends($role.'.layout')
@section('title', 'Edit Invoice')
@section('content')
    <div class="content-wrapper">
        <x-create-form-component 
            actionName="Edit"
            actionType="update"
            entity="{{$invoice->student->Name}}"
            :resetButton=false 
            :imageUploader=false 
            :action="$actionRoute"
            :fields="$fields" 
        />
    </div>
@endsection