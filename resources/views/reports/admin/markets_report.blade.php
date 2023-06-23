@extends('layouts.app')

@section('title')
    Markets Report
@endsection

@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration: none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Markets Report</span>
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
<form method="GET" action="{{ route('admin_reports.generate_markets_report') }}">
    @csrf
    <div class="card shadow">
        <div class="card-header">

            Customize your report

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label for="from">Report Title</label>
                    <div class="">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="Markets Report"required autocomplete="title" autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 form-group">
                    <label for="ward">Ward</label>
                    <div id="wards">
                        <input class="typeahead" id="ward" type="text" placeholder="Ward"required value="All"
                            autocomplete="ward" name="ward" /> @error('ward')
                            <span class="error" style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
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
                        <option value="code">Code</option>
                        <option value="name">Name</option>
                        <option value="ward">Ward</option>
                        <option value="sub_ward">Sub-Ward</option>
                    </select>
                    @error('sort_by')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="">Additional Columns</div>
                    <div class="row">
                        <div class="col-sm-3 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="total_frames" /> Total
                                    Frames </label>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="empty_frames" /> Empty
                                    Frames
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="total_stalls" /> Total
                                    Stalls
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="empty_stalls" /> Empty
                                    Stalls
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-4">

                    <div class="">File Type</div>
                    <div class="row pt-2">

                        <div class="col-sm-4 form-group">
                            <div class="form-check">
                                <label style="cursor: pointer" class="form-check-label">
                                    <input type="radio" class="form-check-input" name="file_type" id="file_type1"
                                        value="PDF" checked /> PDF </label>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group ">
                            <div class="form-check">
                                <label style="cursor: pointer" class="form-check-label">
                                    <input type="radio" class="form-check-input" name="file_type" id="file_type2"
                                        value="CSV" /> CSV </label>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="form-check">
                                <label style="cursor: pointer" class="form-check-label">
                                    <input type="radio" class="form-check-input" name="file_type" id="file_type3"
                                        value="EXCEL" /> EXCEL </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mb-1 my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Generate Report') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
@section('scripts')

@endsection
