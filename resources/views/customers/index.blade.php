@extends('layouts.app')
@section('title')
    Customers
@endsection
@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration: none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Customers</span>
            </h4>
        </div>
        <div class="d-flex ">
            <button onclick="saveWebpage()" type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button onclick="printDiv('printable-content')"  type="button" class="btn  bg-white btn-icon-text border ml-3">
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
    <div class="card-header">Customers</div>
    <div class="card-body">

        <table id="data-tebo1" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
            <thead class="table-header">
                <tr>
                    <th>#</th>
                    <th>Profile</th>
                    <th>NIDA</th>
                    <th>Full Name</th>
                    <th>Mobile Number</th>
                    <th>Physical Address</th>
                    <th>Has Property</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>
                            <div class="profile-image">
                                <img height="40px" width="40px" src="{{ asset('storage/' . $customer->photo) }}"
                                    alt="Profile image"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/user.png') }}';">
                            </div>
                        </td>
                        <td>{{ $customer->nida }}</td>
                        <td>{{ $customer->first_name }} {{ $customer->middle_name }} {{ $customer->last_name }}</td>
                        <td>{{ $customer->mobile }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            @if ($customer->frames || $customer->stalls)
                                <b style="color:green; font-weight:bold">Yes</b>
                            @else
                                <b style="color:red; font-weight:bold">No</b>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('customers.admin_show', $customer) }}" class="btn  btn-outline-info"
                                type="button">
                                View
                            </a>
                            <a href="#" class="btn  btn-outline-danger"
                                onclick="if(confirm('Are you sure want to delete {{ $customer->name }}?')) document.getElementById('delete-customer-{{ $customer->id }}').submit()">
                                Delete
                            </a>
                            <form id="delete-customer-{{ $customer->id }}" method="post"
                                action="{{ route('customers.delete', $customer) }}">
                                @csrf @method('delete')
                            </form>
                        </td>
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
        @if (session('addCustomerCollapse'))
            $('#addCustomerCollapse').addClass('show');
        @endif
    });
</script>
@endsection
