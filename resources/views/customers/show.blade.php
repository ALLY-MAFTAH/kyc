@extends('layouts.app')

@section('title')
    Customer
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
                        <div class="col-md-12  py-2">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">NIDA: </div>
                                            <div style="color:rgb(188, 186, 186)">First Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Middle Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Last Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Mobile Number: </div>
                                            <div style="color:rgb(188, 186, 186)">Address: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div style="color:rgb(3, 3, 87)">{{ $customer->nida }}</div>
                                            <div>{{ $customer->first_name }}</div>
                                            @if ($customer->middle_name)
                                                <div>{{ $customer->middle_name }}</div>
                                            @else
                                                <div>-</div>
                                            @endif
                                            <div>{{ $customer->last_name }}</div>
                                            <div>{{ $customer->mobile }}</div>
                                            @if ($customer->address)
                                                <div>{{ $customer->address }}</div>
                                            @else<div>-</div>
                                            @endif
                                        </h5>
                                        <div class="pt-4 pb-2">
                                            <button href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal-{{ $customer->id }}"
                                                class="btn-outline-primary btn" type="button">EDIT</button>
                                        </div>
                                    </div>
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
                            <i class="mdi mdi-image-filter-frames" style="font-size: 38px;color:rgb(234, 20, 241)"></i>
                            <div class="py-3">
                                <b> {{ $customerFrames->count() }}</b>
                            </div>
                            <div class="">
                                FRAMES
                            </div>
                        </div>
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-table" style="font-size: 40px;color:rgb(244, 149, 7)"></i>
                            <div class="py-3">
                                <b> {{ $customerStalls->count() }}</b>
                            </div>
                            <div class="">
                                CAGES
                            </div>
                        </div>
                        <div class="col text-center"style="">
                            <i class="mdi mdi-cash-usd" style="font-size: 40px;color:rgb(32, 12, 251)"></i>
                            <div class="py-3">
                                @if ($customer && $customer->amounts)
                                    <b>{{ number_format($customer->amounts->sum('amount'), 0, '.', ',') }}</b> TZS
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
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header  text-center" style="font-size: 20px">
                        <div class="row">
                            <div class="col">
                                Frames
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary collapsed" data-toggle="collapse"
                                    data-target="#assignFrameCollapse">Assign New Frame </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    Assigned Frames
                                </div>
                                @forelse ($customerFrames as $frame)
                                    <div class="card shadow mt-2">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="padding:2px;color:rgb(3, 3, 113)">
                                            <span style="font-size: 15px">Frame No: <b>{{ $frame->code }}</b></span>
                                            <a href="{{ route('customers.detach_frame', ['customer' => $customer, 'frameId' => $frame->id]) }}"
                                                onclick="return confirm('Are you sure you want to remove this frame?');"
                                                class="">
                                                <i class="mdi mdi-delete-forever" style="color:red;font-size:30px"></i>
                                            </a>
                                        </div>
                                        <div class="card-body" style="padding: 6px; font-size:13px">
                                            <div>Location: <span style="color:rgb(4, 4, 141)">{{ $frame->location }}</span>
                                            </div>
                                            <div>Price: <span
                                                    style="color:rgb(4, 4, 141)">{{ number_format($frame->price, 0, '.', ',') }}
                                                    Tsh</span></div>
                                            <div>Size: <span style="color:rgb(4, 4, 141)">{{ $frame->size }}</span></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray text-center pt-2" style="font-size: 13px"> 0 Frames</div>
                                @endforelse

                            </div>
                            <div class="col-6">
                                <div id="assignFrameCollapse" style="width: 100%;border-width:0px"
                                    class="accordion-collapse collapse" aria-labelledby="assignFrameCollapse"
                                    data-parent="#assignFrameCollapse">
                                    <div class="accordion-body">
                                        <div class="text-center" style="color:gray">Frames to Assign</div>
                                        <div class="card p-2 mt-2" style="background: var(--form-bg-color)">
                                            <form action="{{ route('customers.attach_frame', $customer) }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <select class="js-example-basic-multiple form-control"
                                                        multiple="multiple" required name="frames[]"
                                                        style="width: 100%;">
                                                        @foreach ($emptyFrames as $frame)
                                                            <option value={{ $frame->id }}>Frame No:
                                                                {{ $frame->code }} &nbsp;&nbsp;&nbsp;
                                                                ({{ $frame->location }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('frames[]')
                                                        <span class="error" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="row mb-2 mt-2">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn  btn-outline-primary">
                                                            {{ __('Assign') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header  text-center" style="font-size: 20px">
                        <div class="row">
                            <div class="col">
                                Stalls
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary collapsed" data-toggle="collapse"
                                    data-target="#assignStallCollapse">Assign New Stall </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    Assigned Stalls
                                </div>
                                @forelse ($customerStalls as $stall)
                                    <div class="card shadow mt-2">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="padding:2px;color:rgb(3, 3, 113)">
                                            <span style="font-size: 15px">Stall No: <b>{{ $stall->code }}</b></span>
                                            <a href="{{ route('customers.detach_stall', ['customer' => $customer, 'stallId' => $stall->id]) }}"
                                                onclick="return confirm('Are you sure you want to remove this stall?');"
                                                class="">
                                                <i class="mdi mdi-delete-forever" style="color:red;font-size:30px"></i>
                                            </a>
                                        </div>
                                        <div class="card-body" style="padding: 6px; font-size:13px">
                                            <div>Location: <span style="color:rgb(4, 4, 141)">{{ $stall->location }}</span>
                                            </div>
                                            <div>Price: <span
                                                    style="color:rgb(4, 4, 141)">{{ number_format($stall->price, 0, '.', ',') }}
                                                    Tsh</span></div>
                                            <div>Type: <span style="color:rgb(4, 4, 141)">{{ $stall->type }}</span></div>
                                            <div>Size: <span style="color:rgb(4, 4, 141)">{{ $stall->size }}</span></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray text-center pt-2" style="font-size: 13px"> 0 Stalls</div>
                                @endforelse

                            </div>
                            <div class="col-6">
                                <div id="assignStallCollapse" style="width: 100%;border-width:0px"
                                    class="accordion-collapse collapse" aria-labelledby="assignStallCollapse"
                                    data-parent="#assignStallCollapse">
                                    <div class="accordion-body">
                                        <div class="text-center" style="color:gray">Stalls to Assign</div>
                                        <div class="card p-2 mt-2" style="background: var(--form-bg-color)">
                                            <form action="{{ route('customers.attach_stall', $customer) }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <select class="js-example-basic-multiple form-control"
                                                        multiple="multiple" required name="stalls[]" style="width: 100%;">
                                                        @foreach ($emptyStalls as $stall)
                                                            <option value={{ $stall->id }}>Stall No:
                                                                {{ $stall->code }} &nbsp;&nbsp;&nbsp;
                                                                ({{ $stall->location }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('stalls[]')
                                                        <span class="error" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="row mb-2 mt-2">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn  btn-outline-primary">
                                                            {{ __('Assign') }}
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="editModal-{{ $customer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                        <button type="button" style="background-color:red" class="btn-close  btn-danger"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        @include('includes.edit_customer_form')
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
            @if (session('addStallCollapse'))
                $('#addStallCollapse').addClass('show');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('modalOpen'))
                $('#editCustomerModal').addClass('show');
            @endif
        });
    </script>
@endsection
