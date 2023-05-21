@extends('layouts.app')
@section('styles')
@endsection

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-2"> Customers</h3>
        <div class="d-flex">
            <button type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
        </div>
        <br>
    </div>
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
                        <th>NIDA</th>
                        <th>Full Name</th>
                        <th>Mobile Number</th>
                        <th>Physical Address</th>
                        {{-- <th class="text-center">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $customer->nida }}</td>
                            <td>{{ $customer->first_name }} {{ $customer->middle_name }} {{ $customer->last_name }}</td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->address }}</td>
                            {{-- <td class="text-center">
                                <a href="{{ route('customers.show', $customer) }}" class="btn  btn-outline-info collapsed"
                                    type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
                                <a href="#" class="btn  btn-outline-danger"
                                    onclick="if(confirm('Are you sure want to delete {{ $customer->name }}?')) document.getElementById('delete-customer-{{ $customer->id }}').submit()">
                                    Delete
                                </a>
                                <form id="delete-customer-{{ $customer->id }}" method="post"
                                    action="{{ route('customers.delete', $customer) }}">
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
            @if (session('addCustomerCollapse'))
                $('#addCustomerCollapse').addClass('show');
            @endif
        });
    </script>
@endsection
