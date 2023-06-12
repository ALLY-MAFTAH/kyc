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
{{-- <div class="card shadow">
    <div class="card-header">Customize your report</div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.generate_markets_report') }}">
            @csrf
            <div class="row">
                <input type="hidden" name="from_date" id="from_date">
                <input type="hidden" name="to_date" id="to_date">
                <div class="col-sm-3 form-group">
                    <label for="from">Report Title</label>
                    <div class="">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="Kinondoni Municipal Council "required autocomplete="title" autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 form-group">
                    <label for="to">Subtitle</label>
                    <div class="">
                        <input id="subtitle" type="text"
                            class="form-control @error('subtitle') is-invalid @enderror" name="subtitle"
                            value="Customers Report"required autocomplete="subtitle" autofocus>
                        @error('subtitle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 form-group">
                    <label for="ward">Ward</label>
                    <div id="wards">
                        <input class="typeahead" id="ward" type="text" placeholder="Ward"required
                            value="{{ old('ward') }}" autocomplete="ward" name="ward" /> @error('ward')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 form-group">
                    <label for="street">Sub-Ward</label>
                    <div id="streets">
                        <input type="text" class="typeahead" id="street" name="sub_ward"
                            value="{{ old('sub_ward') }}" autocomplete="street" placeholder="Sub-Ward"required />
                        @error('sub_ward')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label>From</label>
                    <input class=" form-control" required name="from_date" type="date">
                    @error('from_date')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 form-group">
                    <label>To</label>
                    <input class=" form-control" required name="to_date" type="date">
                    @error('to_date')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 form-group">
                    <label>Orientation</label>
                    <select class="js-example-basic-single form-control" required name="orientation"
                        style="width: 100%;">
                        <option value="">--</option>
                        <option value="potrait">Potrait</option>
                        <option value="landscape">Landscape</option>
                    </select>
                    @error('orientation')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 form-group">
                    <label>Sort By</label>
                    <select class="js-example-basic-single form-control" required name="sort_by"
                        style="width: 100%;">
                        <option value="">None</option>
                        <option value="name">Name</option>
                        <option value="code">Code</option>
                        <option value="ward">Ward</option>
                        <option value="sub_ward">Sub-Ward</option>
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
</div> --}}
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
