@extends('layouts.app')
@section('title')
    Payments
@endsection
@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration: none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Payments</span>
            </h4>
        </div>
        <div class="d-flex ">
            <button type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
        </div>
    </div>
@endsection
@if (session('info'))
    <div class="alert alert-info" role="alert">
        {{ session('info') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif
<div class="card shadow">
    <div class="card-header">Payments</div>
    <div class="card-body">

        <table id="data-tebo1" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
            <thead class="table-header">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Market</th>
                    <th>Customer</th>
                    <th>Frame</th>
                    <th>Stall</th>
                    <th>Amount</th>
                    <th>Receipt Number</th>
                    <th>Term</th>
                    {{-- <th class="text-center">Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $index => $payment)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>
                            {{ Illuminate\Support\Carbon::parse($payment->date)->format('D, d M Y') }}
                        </td>
                        <td>{{ $payment->market->name }}</td>
                        <td>{{ $payment->customer->first_name }} {{ $payment->customer->middle_name }}
                            {{ $payment->customer->last_name }}</td>
                        <td>
                            @if ($payment->frame)
                                {{ $payment->frame->code }}
                            @endif
                        </td>
                        <td>
                            @if ($payment->stall)
                                {{ $payment->stall->code }}
                            @endif
                        </td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ $payment->month }} {{ $payment->year }}</td>
                        {{-- <td class="text-center">
                                <a href="{{ route('payments.admin_show', $payment) }}" class="btn  btn-outline-info"
                                    type="button">
                                     View
                                </a>
                                <a href="#" class="btn  btn-outline-danger"
                                    onclick="if(confirm('Are you sure want to delete {{ $payment->name }}?')) document.getElementById('delete-payment-{{ $payment->id }}').submit()">
                                    Delete
                                </a>
                                <form id="delete-payment-{{ $payment->id }}" method="post"
                                    action="{{ route('payments.delete', $payment) }}">
                                    @csrf @method('delete')
                                </form>
                            </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        @if (session('addPaymentCollapse'))
            $('#addPaymentCollapse').addClass('show');
        @endif
    });
</script>
@endsection
