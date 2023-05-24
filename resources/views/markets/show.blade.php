@extends('layouts.app')

@section('title')
    Market
@endsection

@section('content')
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
    <div class="page-wrapper mdc-toolbar-fixed-adjust">

        <div class="row">
            <div class="col-md-6 pb-2">
                <div class="card shadow px-2">
                    <div class="row">
                        <div class="col-md-9  py-2">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">Code: </div>
                                            <div style="color:rgb(188, 186, 186)">Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Ward: </div>
                                            <div style="color:rgb(188, 186, 186)">Sub-Ward: </div>
                                            <div style="color:rgb(188, 186, 186)">Manager Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Manager Phone: </div>
                                            <div style="color:rgb(188, 186, 186)">Size: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div style="color:rgb(3, 3, 87)">{{ $market->code }}</div>
                                            <div>{{ $market->name }}</div>
                                            <div>{{ $market->ward }}</div>
                                            <div>{{ $market->sub_ward }}</div>
                                            <div>{{ $market->manager_name }}</div>
                                            <div>{{ $market->manager_mobile }}</div>
                                            @if ($market->size)
                                                <div>{{ $market->size }} </div>
                                            @else
                                                <div class="">
                                                    -
                                                </div>
                                            @endif
                                        </h5>
                                        <div class="pt-4 pb-2">
                                            <button href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal-{{ $market->id }}"
                                                class="btn-outline-primary btn" type="button">EDIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  py-2">
                            <div class="card p-1" style="background-color:rgba(232, 239, 245, 0.396)">
                                <div class="pb-2 text-center">
                                    <b class="">Sections</b>
                                </div>
                                <div class="label-container text-center row">
                                    @foreach ($market->sections as $section)
                                        <div class="col">

                                            <label class="p-1 valid-label">{{ $section->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-2">
                <div class="card shadow">
                    <div class="card-header text-center">Summary</div>
                    <div class="row px-2 pt-2">
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-account-multiple" style="font-size: 38px;color:rgb(38, 137, 5)"></i>
                            <div class="py-3">
                                <b> {{ $market->customers()->count() }}</b>
                            </div>
                            <div class="">
                                CUSTOMERS
                            </div>
                        </div>
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-image-filter-frames" style="font-size: 38px;color:rgb(234, 20, 241)"></i>
                            <div class="py-3">
                                <b> {{ $market->frames->count() }}</b>
                            </div>
                            <div class="">
                                FRAMES
                            </div>
                        </div>
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-table" style="font-size: 40px;color:rgb(244, 149, 7)"></i>
                            <div class="py-3">
                                <b> {{ count($market->cages) }}</b>
                            </div>
                            <div class="">
                                CAGES
                            </div>
                        </div>
                        <div class="col text-center"style="">
                            <i class="mdi mdi-cash-usd" style="font-size: 40px;color:rgb(32, 12, 251)"></i>
                            <div class="py-3">
                                @if ($market && $market->amounts)
                                    <b>{{ number_format($market->amounts->sum('amount'), 0, '.', ',') }}</b> TZS
                                @else
                                    <b>0</b> TZS
                                @endif
                            </div>
                            <div class="">
                                CONTRIBUTION
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <div class="card shadow">
            <div class="card-header  text-center" style="font-size: 20px">
                <div class="row">
                    <div class="col">
                        Frames
                    </div>
                    <div class="col">
                        <button type="button" class="btn  ml-3 btn-primary collapsed"data-bs-toggle="collapse"
                            data-bs-target="#addFrameCollapse"> Add Frame </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="addFrameCollapse" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                    aria-labelledby="addFrameCollapse" data-bs-parent="#addFrameCollapse">
                    <div class="accordion-body">
                        <div class="text-center" style="color:gray">Add Frame</div>
                        <div class="card p-2 mt-1" style="background: var(--form-bg-color)">
                            @include('includes.add_frame_form')
                        </div>
                        <br>
                    </div>
                </div>
                <div class="table-responsive-lg">
                    <table id="data-tebo1" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
                        <thead class=" table-head">
                            <tr>
                                <th class="text-center" style="max-width: 20px">#</th>
                                <th>Code</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Current Customer</th>
                                <th>Size</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($market->frames as $index => $frame)
                                <tr>
                                    <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                    <td> {{ $frame->code }}</td>
                                    <td> {{ $frame->location }} </td>
                                    <td> {{ number_format($frame->price, 0, '.', ',') }} Tsh </td>
                                    <td>
                                        @if ($frame->customer)
                                            <a style="text-decoration: none"
                                                href="{{ route('customers.show', ['customer' => $frame->customer, 'marketId' => $market->id]) }}">
                                                {{ $frame->customer->first_name }}
                                                {{ $frame->customer->middle_name }}
                                                {{ $frame->customer->last_name }}
                                            </a>
                                        @else
                                            <label class="p-1 m-0 text-white bg-danger">Empty</label>
                                        @endif
                                    </td>
                                    <td> {{ $frame->size }} </td>
                                    <td class="text-center">
                                        <a href="#" class="btn  btn-outline-info" data-toggle="modal"
                                            data-target="#editFrameModal-{{ $frame->id }}" type="button">
                                            Edit
                                        </a>
                                        <a href="#" class="btn  btn-outline-danger"
                                            onclick="if(confirm('Are you sure want to delete frame number: {{ $frame->code }}?')) document.getElementById('delete-frame-{{ $frame->id }}').submit()">
                                            Delete
                                        </a>
                                        <form id="delete-frame-{{ $frame->id }}" method="post"
                                            action="{{ route('frames.delete', $frame) }}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                    <div class="modal fade" id="editFrameModal-{{ $frame->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Frame</h5>
                                                    <button type="button" style="background-color:red"
                                                        class="btn-close  btn-danger" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    @include('includes.edit_frame_form')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card shadow">
            <div class="card-header  text-center" style="font-size: 20px">
                <div class="row">
                    <div class="col">
                        Cages
                    </div>
                    <div class="col">
                        <button type="button" class="btn  ml-3 btn-primary collapsed"data-bs-toggle="collapse"
                            data-bs-target="#addCageCollapse"> Add Cage </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="addCageCollapse" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                    aria-labelledby="addCageCollapse" data-bs-parent="#addCageCollapse">
                    <div class="accordion-body">
                        <div class="text-center" style="color:gray">Add Cage</div>
                        <div class="card p-2 mt-1" style="background: var(--form-bg-color)">
                            @include('includes.add_cage_form')
                        </div>
                        <br>
                    </div>
                </div>
                <div class="table-responsive-lg">
                    <table id="data-tebo2" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
                        <thead class=" table-head">
                            <tr>
                                <th class="text-center" style="max-width: 20px">#</th>
                                <th>Code</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Current Customer</th>
                                <th>Size</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($market->cages as $index => $cage)
                                <tr>
                                    <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                    <td> {{ $cage->code }}</td>
                                    <td> {{ $cage->location }} </td>
                                    <td> {{ number_format($cage->price, 0, '.', ',') }} Tsh </td>
                                    <td> {{ $cage->type }} </td>
                                    <td>
                                        @if ($cage->customer)
                                            <a style="text-decoration: none"
                                                href="{{ route('customers.show', ['customer' => $cage->customer, 'marketId' => $market->id]) }}">
                                                {{ $cage->customer->first_name }}
                                                {{ $cage->customer->middle_name }}
                                                {{ $cage->customer->last_name }}
                                            </a>
                                        @else
                                            <label class="p-1 m-0 text-white bg-danger">Empty</label>
                                        @endif
                                    </td>
                                    <td> {{ $cage->size }} </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-outline-info"
                                           data-toggle="modal" data-target="#editCageModal-{{$cage->id}}" type="button">
                                            Edit
                                        </a>
                                        <a href="#" class="btn  btn-outline-danger"
                                            onclick="if(confirm('Are you sure want to delete cage number: {{ $cage->code }}?')) document.getElementById('delete-cage-{{ $cage->id }}').submit()">
                                            Delete
                                        </a>
                                        <form id="delete-cage-{{ $cage->id }}" method="post"
                                            action="{{ route('cages.delete', $cage) }}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                    <div class="modal fade" id="editCageModal-{{ $cage->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Cage</h5>
                                                    <button type="button" style="background-color:red"
                                                        class="btn-close  btn-danger" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    @include('includes.edit_cage_form')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br>
        <div class="card shadow">
            <div class="card-header  text-center" style="font-size: 20px">
                <div class="row">
                    <div class="col">
                        Customer
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add Customer</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <a class="dropdown-item" href="#"data-bs-toggle="collapse"
                                    data-bs-target="#addCustomerCollapse">New Customer</a>
                                <hr>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#addCustomerModal">From Existing</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="addCustomerCollapse" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                    aria-labelledby="addCustomerCollapse" data-bs-parent="#addCustomerCollapse">
                    <div class="accordion-body">
                        <div class="text-center" style="color:gray">Register Customer</div>
                        <div class="card p-2 mt-1" style="background: var(--form-bg-color)">
                            @include('includes.add_customer_form')
                        </div>
                        <br>
                    </div>
                </div>
                <div class="table-responsive-lg">
                    <table id="data-tebo3" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
                        <thead class=" table-head">
                            <tr>
                                <th class="text-center" style="max-width: 20px">#</th>
                                <th>NIDA</th>
                                <th>Full Name</th>
                                <th>Mobile Number</th>
                                <th>Address</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($market->customers()->get() as $index => $customer)
                                <tr>
                                    <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                    <td> {{ $customer->nida }}</td>
                                    <td> {{ $customer->first_name }} {{ $customer->middle_name }}
                                        {{ $customer->last_name }} </td>
                                    <td> {{ $customer->mobile }} </td>
                                    <td> {{ $customer->address }} </td>
                                    <td class="text-center">
                                        <a href="{{ route('customers.show', ['customer' => $customer, 'marketId' => $market->id]) }}"
                                            class="btn  btn-outline-info" type="button"> View
                                        </a>
                                        <a href="#" class="btn  btn-outline-danger" type="button"
                                            onclick="if(confirm('Are you sure want to remove this customer from this market ? ')) document.getElementById('remove-customer-from-market-{{ $customer->id }}').submit()">
                                            Remove
                                        </a>
                                        <form id="remove-customer-from-market-{{ $customer->id }}" method="post"
                                            action="{{ route('customers.remove_from_market', $customer) }}">
                                            @csrf
                                            <input type="number" name="market_id" value="{{ $market->id }}" hidden>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div><br>

        <div class="modal fade" id="editModal-{{ $market->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Market</h5>
                        <button type="button" style="background-color:red" class="btn-close  btn-danger"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        @include('includes.edit_market_form')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                        <button type="button" style="background-color:red" class="btn-close btn-danger"
                            data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form action="{{ route('customers.add_to_market', $market) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select class="js-example-basic-single form-control" required name="customer_id"
                                        style="width: 100%;">
                                        <option value="">-- Select Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ old('customer_id', $customer->id) }}">{{ $customer->nida }}
                                                -
                                                {{ $customer->first_name }} {{ $customer->middle_name }}
                                                {{ $customer->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2 mt-2">
                                <div class="text-center">
                                    <button type="submit" class="btn  btn-outline-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
    <script>
        $(document).ready(function() {
            @if (session('addCageCollapse'))
                $('#addCageCollapse').addClass('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('addCustomerCollapse'))
                $('#addCustomerCollapse').addClass('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('editMarketModal'))
                $('#editMarketModal').addClass('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('editFrameModal'))
                $('#editFrameModal').addClass('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('editCageModal'))
                $('#editCageModal').addClass('show');
            @endif
        });
    </script>
@endsection
