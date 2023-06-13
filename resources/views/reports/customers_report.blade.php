@extends('layouts.app')

@section('title')
    Customers Report
@endsection

@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration: none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Customers Report</span>
            </h4>
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
    <div class="card-header">Customize your report</div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.generate_customers_report') }}">
            @csrf
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label for="from">Report Title</label>
                    <div class="">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="Customers Report"required autocomplete="title" autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 form-group">
                    <label>Market</label>
                    <select class="js-example-basic-single form-control" required name="market_id"
                        style="width: 100%;">
                        <option value="All">All</option>
                        @foreach ($markets as $market)
                        <option value="{{$market->id}}">{{$market->name}}</option>
                        @endforeach
                    </select>
                    @error('market')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 form-group">
                    <label>Orientation</label>
                    <select class="js-example-basic-single form-control" required name="orientation"
                        style="width: 100%;">
                        <option value="landscape">Landscape</option>
                        <option value="potrait">Potrait</option>
                    </select>
                    @error('orientation')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 form-group">
                    <label>Sort By</label>
                    <select class="js-example-basic-single form-control" required name="sort_by" style="width: 100%;">
                        <option value="nida">NIDA</option>
                        <option value="first_name">Name</option>
                    </select>
                    @error('sort_by')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-1 my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Generate Report') }}
                    </button>
                </div>
            </div>
        </form>

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
