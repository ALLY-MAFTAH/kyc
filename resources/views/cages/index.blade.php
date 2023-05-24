@extends('layouts.app')
@section('styles')
@endsection

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-2"> Stalls</h3>
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
        <div class="card-header">Stalls
        </div>
        <div class="card-body">

            <table id="data-tebo1" class="dt-responsive nowrap rounded-3 table table-hover"style="width: 100%">
                <thead class="table-header">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Market</th>
                        <th>Current Customer</th>
                        <th>Type</th>
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stalls as $index => $stall)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $stall->code }}</td>
                            <td>{{ $stall->location }}</td>
                            <td>{{ number_format($stall->price, 0, '.', ',') }} Tsh</td>
                            <td>{{ $stall->market->name }}</td>
                            <td>
                                @if ($stall->customer)
                                    {{-- <a style="text-decoration: none"
                                        href="{{ route('customers.show', ['customer' => $stall->customer, 'marketId' => $market->id]) }}"> --}}
                                        {{ $stall->customer->first_name }}
                                        {{ $stall->customer->middle_name }}
                                        {{ $stall->customer->last_name }}
                                    {{-- </a> --}}
                                @else
                                    <label class="p-1 m-0 text-white bg-danger">Empty</label>
                                @endif
                            </td>
                            <td>{{ $stall->type }}</td>
                            <td>{{ $stall->size }}</td>
                            {{-- <td class="text-center">
                                <a href="{{ route('stalls.show', $stall) }}" class="btn  btn-outline-info collapsed"
                                    type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
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
            @if (session('addStallCollapse'))
                $('#addStallCollapse').addClass('show');
            @endif
        });
    </script>
@endsection
