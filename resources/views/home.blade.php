@extends('layouts.app')

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-0"> Dashboard <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">System Data Summary</span>
        </h3>
        <div class="d-flex">
            <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                <i class="mdi mdi-email btn-icon-prepend"></i> Email </button>
            <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
            <button type="button" class="btn btn-sm ml-3 btn-success"> Add User </button>
        </div>
        <br>
    </div>

    <div class="card">
        <div class="card-header">Dashboard
        </div>
        <div class="card-body">
            Summary
        </div>
    </div>
@endsection
@section('scripts')


@endsection
