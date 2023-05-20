
@extends('layouts.app')
@section('styles')
@endsection

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-2"> Cages</h3>
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
        <div class="card-header">Cages
        </div>
        <div class="card-body">

            <table id="data-tebo1" class="dt-responsive nowrap rounded-3 table table-hover"style="width: 100%">
                <thead class="table-header">
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Market</th>
                        <th>Size</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cages as $index => $cage)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $cage->number }}</td>
                            <td>{{ $cage->location }}</td>
                            <td>{{ $cage->type }}</td>
                            <td>{{ $cage->price }}</td>
                            <td>{{ $cage->market->name }}</td>
                            <td>{{ $cage->size }}</td>
                            <td class="text-center">
                                <a href="{{ route('cages.show', $cage) }}" class="btn  btn-outline-info collapsed"
                                    type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
                            </td>
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
            @if (session('addCageCollapse'))
                $('#addCageCollapse').addClass('show');
            @endif
        });
    </script>
@endsection