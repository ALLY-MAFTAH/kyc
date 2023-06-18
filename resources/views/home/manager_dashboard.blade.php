@extends('layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-0"> Dashboard <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">System Data Summary</span>
        </h3>
        <div class="d-flex ">
            <button onclick="saveWebpage()" type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button onclick="printDiv('printable-content')" type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
            @if (Auth::user()->market_id && Auth::user()->status && Auth::user()->is_manager)
                <button onclick="goToMarket(event)" data-id="{{ Auth::user()->market_id }}" type="button"
                    class="btn ml-3 btn-primary collapsed"> Manage Market </button>
            @endif
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
    <div class="row">
        <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-2">
            <div class="card bg-warning">
                <div class=" card-body px-3 py-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="color-card">
                            <p class="mb-0 color-card-head">
                            <h4>Frames</h4>
                            </p>
                            <h2 class="text-white">{{ $allFrames->count() }}</span>
                            </h2>
                        </div>
                        <i class="card-icon-indicator mdi mdi-image-filter-frames bg-inverse-icon-success"></i>
                    </div>
                    <h6 class="text-white">
                        {{ $emptyFrames->count() . ' Empty frames'}}
                    </h6>
                </div>
            </div>
        </div>
        <div class="pl-0 col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-2">
            <div class="card " style="background: rgb(0, 166, 255)">
                <div class="card-body px-3 py-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="color-card">
                            <p class="mb-0 color-card-head">
                            <h4>Stalls</h4>
                            </p>
                            <h2 class="text-white"> {{ $allStalls->count() }}
                            </h2>
                        </div>
                        <i class="card-icon-indicator mdi mdi-table bg-inverse-icon-warning"></i>
                    </div>
                    <h6 class="text-white">
                        {{ $emptyStalls->count() . ' Empty stalls'}}
                    </h6>                </div>
            </div>
        </div>
        <div class="pl-0 col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-2">
            <div class="card " style="background:rgb(192, 105, 18)">
                <div class="card-body px-3 py-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="color-card">
                            <p class="mb-0 color-card-head">
                            <h4>Customers</h4>
                            </p>
                            <h2 class="text-white"> {{ $allCustomers->count() }}
                            </h2>
                        </div>
                        <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-primary"></i>
                    </div>
                    <h6 class="text-white">Excluding customers with no property</h6>
                </div>
            </div>
        </div>
        <div class="pl-0 col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-2">
            <div class="card bg-success">
                <div class="card-body px-3 py-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="color-card">
                            <p class="mb-0 color-card-head">
                            <h4>Collection</h4>
                            </p>
                            <h2 class="text-white">{{ number_format($totalMarketCollection, 0, '.', ',') }} <span
                                    class="h5">TZS</span>
                            </h2>
                        </div>
                        <i class="card-icon-indicator mdi mdi-currency-usd bg-inverse-icon-danger"></i>
                    </div>
                    <h6 class="text-white">Since January, this year</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-xl-12 stretch-card grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <h5>Frames and Stalls collection</h5>
                            <p class="text-muted"> Show overview from Jan {{ date('Y') }} - {{ date('M') }}
                                {{ date('Y') }}
                            </p>
                        </div>
                        <div class="col-sm-5 text-md-right">
                            {{-- <button type="button"
                                class="btn btn-icon-text mb-3 mb-sm-0 btn-inverse-primary font-weight-normal">
                                <i class="mdi mdi-email btn-icon-prepend"></i>Download Report </button> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="shadow card mb-3 mb-sm-0">
                                <div class="card-body py-3 px-4">
                                    <p class="m-0 survey-head text-warning">Collected from frames</p>
                                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                                        <div>
                                            <h3 class="m-0 survey-value pt-2">
                                                {{ number_format($totalFramesCollection, 0, '.', ',') }}<span
                                                    class="h5"> TZS</span>
                                            </h3>
                                            @if ($totalFramesCollection >= $totalStallsCollection)
                                                <p class="text-success m-0">The leading source</p>
                                            @else
                                                <p class="text-danger m-0">The trailing source</p>
                                            @endif
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-square-inc-cash text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="shadow card mb-3 mb-sm-0">
                                <div class="card-body py-3 px-4">
                                    <p class="m-0 survey-head text-warning">Collected from stalls</p>
                                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                                        <div>
                                            <h3 class="m-0 survey-value pt-2">
                                                {{ number_format($totalStallsCollection, 0, '.', ',') }}<span
                                                    class="h5"> TZS</span>
                                            </h3>
                                            @if ($totalFramesCollection >= $totalStallsCollection)
                                                <p class="text-danger m-0">The trailing source</p>
                                            @else
                                                <p class="text-success m-0">The leading source</p>
                                            @endif
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-square-inc-cash text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="shadow card">
                                <div class="card-body py-3 px-4">
                                    <p class="m-0 survey-head text-warning">Target collection</p>
                                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                                        <div>
                                            <h3 class="m-0 survey-value pt-2">
                                                {{ number_format($totalMarketCollection, 0, '.', ',') }}<span class="h5">TZS</span>
                                            </h3>
                                            <p class="text-danger m-0">{{ number_format(499855000, 0, '.', ',') }}<span
                                                    class="h6"> TZS</span> behind the target</p>
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-square-inc-cash text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-7">
            <div class="card ">
                <div class="card-header">
                    <h5> Collection per market from Jan, {{ date('Y') }} - {{ date('M') }}, {{ date('Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="flot-chart-wrapper">
                        <canvas id="market-chart" height="150"></canvas>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <p class="mb-0 text-muted">Total Collected Amount</p>
                        <h5 class="d-inline-block survey-value pt-2 mb-0">
                            {{ number_format($totalMarketCollection, 0, '.', ',') }} <span class="h5">TZS</span>
                        </h5>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body px-0 overflow-auto">
                    <h4 class="card-title pl-4">Top 5 Customers - {{ date('Y') }}</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topFiveCustomers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $customer->photo) }}" alt="image" />
                                                <div class="table-user-name ml-3">
                                                    <p class="mb-0 font-weight-medium"> <a style="text-decoration: none"
                                                            href="{{ route('customers.admin_show', $customer) }}">
                                                            {{ $customer->first_name }} {{ $customer->middle_name }}
                                                            {{ $customer->last_name }}</a> </p>
                                                    <small> {{ $customer->nida }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h6 pr-2">
                                            {{ number_format($customer->payments_sum_amount, 0, '.', ',') }}
                                            TZS</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td></td>
                                        <td class="text-center">

                                            No payment record
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    {{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        function goToMarket(event) {
            var id = event.target.dataset.id;
            window.location.href = '/manager-show-market/' + id;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var graphData = @json($graphData);
            var ctx = document.getElementById('market-chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: graphData.labels,
                    datasets: [{
                        label: 'Collected Amount ',
                        data: graphData.data,
                        backgroundColor: 'rgba(75, 12, 192, 0.2)',
                        borderColor: 'rgba(5, 192, 12, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value.toLocaleString() + ' TZS';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
