@extends('layouts.app')
@section('styles')
@endsection

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-2"> Frames</h3>
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
        <div class="card-header">Frames
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
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frames as $index => $frame)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $frame->code }}</td>
                            <td>{{ $frame->location }}</td>
                            <td>{{ number_format($frame->price, 0, '.', ',') }} Tsh</td>
                            <td>{{ $frame->market->name }}</td>
                            <td>
                                @if ($frame->customer)
                                    {{-- <a style="text-decoration: none"
                                        href="{{ route('customers.show', ['customer' => $frame->customer, 'marketId' => $market->id]) }}"> --}}
                                        {{ $frame->customer->first_name }}
                                        {{ $frame->customer->middle_name }}
                                        {{ $frame->customer->last_name }}
                                    {{-- </a> --}}
                                @else
                                    <label class="p-1 m-0 text-white bg-danger">Empty</label>
                                @endif
                            </td>
                            <td>{{ $frame->size }}</td>
                            {{-- <td class="text-center">
                                <a href="{{ route('frames.show', $frame) }}" class="btn  btn-outline-info collapsed"
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
            @if (session('addFrameCollapse'))
                $('#addFrameCollapse').addClass('show');
            @endif
        });
    </script>
@endsection
