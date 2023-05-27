@extends('layouts.app')

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-0"> Dashboard <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">System Data Summary</span>
        </h3>
        <div class="d-flex">
            <button type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
            @if (Auth::user()->market_id)
                <button onclick="goToMarket(event)" data-id="{{ Auth::user()->market_id }}" type="button"
                    class="btn ml-3 btn-primary collapsed"> Manage Market </button>
            @endif
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
    <script>
        function goToMarket(event) {
            var id = event.target.dataset.id;
            window.location.href = '/show-market/' + id;
        }
    </script>
@endsection
