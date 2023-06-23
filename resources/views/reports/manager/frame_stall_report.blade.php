@extends('layouts.app')

@section('title')
    Frames & Stalls Report
@endsection

@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration: none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Frames & Stalls Report</span>
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
<form method="GET" action="{{ route('manager_reports.generate_frame_stall_report') }}" onsubmit="return validateForm()">
    @csrf
    <div class="card shadow">
        <div class="card-header">

            Customize your report

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="from">Report Title</label>
                    <div class="">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="Frame & Stall Payments Report "required autocomplete="title" autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Market</label>
                    <select class="js-example-basic-single form-control" required name="market_id" style="width: 100%;">
                        <option value="All">All</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                    </select>
                    @error('market')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4 form-group">
                    <label>Customer</label>
                    <select class="js-example-basic-single form-control" required name="customer_id"
                        style="width: 100%;">
                        <option value="All">All</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->first_name }}
                                {{ $customer->middle_name }} {{ $customer->last_name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 form-group" hidden>
                    <label>Orientation</label>
                    <select class="js-example-basic-single form-control" required name="orientation"
                        style="width: 100%;">
                        <option value="landscape">Landscape</option>
                        {{-- <option value="potrait">Potrait</option> --}}
                    </select>
                    @error('orientation')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4 form-group">
                    <label for="">Month</label>
                    <select class="js-example-basic-single form-control" aria-placeholder="Month" required
                        name="month" style="width: 100%;">
                        <option value="All Months">All</option>
                        <option value="January">January
                        </option>
                        <option value="February">February
                        </option>
                        <option value="March">March
                        </option>
                        <option value="April">April
                        </option>
                        <option value="May">May
                        </option>
                        <option value="June">June
                        </option>
                        <option value="July">July
                        </option>
                        <option value="August">August
                        </option>
                        <option value="September">September
                        </option>
                        <option value="October">October
                        </option>
                        <option value="November">November
                        </option>
                        <option value="December">December
                        </option>
                    </select>
                    @error('months[]')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label>Year</label>
                    <select class="js-example-basic-single form-control" required name="year" style="width: 100%;">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear, $currentYear - 50);
                        @endphp
                        {{-- <option value="All">All</option> --}}
                        @foreach ($years as $year)
                            <option value="{{ $year }}">
                                {{ $year }}</option>
                        @endforeach
                    </select>
                    @error('sort_by')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label>Sort By</label>
                    <select class="js-example-basic-single form-control" required name="sort_by" style="width: 100%;">
                        <option value="market_id">Market</option>
                        <option value="customer_id">Cutomer</option>
                    </select>
                    @error('sort_by')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div>Show Data For</div>
                    <div class="row">
                        <div class="col-sm-4 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="check_frames" type="checkbox" class="form-check-input" name="frames"
                                        checked /> Frames
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group pt-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="check_stalls" type="checkbox" class="form-check-input" name="stalls"
                                        checked /> Stalls
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div>File Type</div>
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
                    <button id="reportBtn" type="submit" class="btn btn-primary">
                        {{ __('Generate Report') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
@section('scripts')
<script>
    function validateForm() {
        const framesCheckbox = document.getElementById('check_frames');
        const stallsCheckbox = document.getElementById('check_stalls');

        if (!framesCheckbox.checked && !stallsCheckbox.checked) {
            alert('Please select at least one checkbox in "Show Data For" section.');
            return false;
        }

        return true;
    }
</script>
@endsection
