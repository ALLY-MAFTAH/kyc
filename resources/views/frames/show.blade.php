@extends('layouts.app')

@section('title')
    Frame
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
            <div class="col-md-7 pb-2">
                <div class="card shadow px-2">
                    <div class="row">
                        <div class="col-md-12  py-2">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">Number: </div>
                                            <div style="color:rgb(188, 186, 186)">Location: </div>
                                            <div style="color:rgb(188, 186, 186)">Price: </div>
                                            <div style="color:rgb(188, 186, 186)">Market: </div>
                                            <div style="color:rgb(188, 186, 186)">Current Customer: </div>
                                            <div style="color:rgb(188, 186, 186)">Size: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div style="color:rgb(3, 3, 87)">{{ $frame->code }}</div>
                                            <div>{{ $frame->location }}</div>
                                            <div>{{ $frame->price }}</div>
                                            <div>{{ $frame->market->name }}</div>
                                            @if ($frame->customer)
                                                <div>{{ $customer->first_name }}{{ $customer->middle_name }}
                                                    {{ $customer->last_name }}</div>
                                            @else
                                                <label class="p-1 m-0 text-white bg-danger">Empty</label>
                                            @endif
                                            @if ($frame->size)
                                                <div>{{ $frame->size }}</div>
                                            @else<div>-</div>
                                            @endif
                                        </h5>
                                        <div class="pt-4 pb-2">
                                            <button href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal-{{ $frame->id }}"
                                                class="btn-outline-primary btn" type="button">EDIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 pb-2">
                <div class="card shadow">
                    <div class="card-header text-center">Summary</div>
                    <div class="row px-2 pt-2">
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-image-filter-frames" style="font-size: 38px;color:rgb(234, 20, 241)"></i>
                            <div class="py-3">
                                <b> {{ $frameFrames->count() }}</b>
                            </div>
                            <div class="">
                                FRAMES
                            </div>
                        </div>
                        <div class="col text-center"style="border-right: 1px dashed #333;">
                            <i class="mdi mdi-table" style="font-size: 40px;color:rgb(244, 149, 7)"></i>
                            <div class="py-3">
                                <b> {{ $frameCages->count() }}</b>
                            </div>
                            <div class="">
                                CAGES
                            </div>
                        </div>
                        <div class="col text-center"style="">
                            <i class="mdi mdi-cash-usd" style="font-size: 40px;color:rgb(32, 12, 251)"></i>
                            <div class="py-3">
                                @if ($frame && $frame->amounts)
                                    <b>{{ number_format($frame->amounts->sum('amount'), 0, '.', ',') }}</b> TZS
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
                                    data-target="#addFrameCollapse">Assign New Frame </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    Assigned Frames
                                </div>

                                @forelse ($frameFrames as $frame)
                                    <div class="card shadow mt-2">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="padding:2px;color:rgb(3, 3, 113)">
                                            <span style="font-size: 15px">Frame No: <b>{{ $frame->code }}</b></span>
                                            <a href="{{ route('frames.detach_frame', ['frame' => $frame, 'frameId' => $frame->id]) }}"
                                                class=""><i class="mdi mdi-delete-forever"
                                                    style="color:red;font-size:30px"></i></a>
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
                                <div id="addFrameCollapse" style="width: 100%;border-width:0px"
                                    class="accordion-collapse collapse" aria-labelledby="addFrameCollapse"
                                    data-parent="#addFrameCollapse">
                                    <div class="accordion-body">
                                        <div class="text-center" style="color:gray">Frames to Assign</div>
                                        <div class="card p-2 mt-2" style="background: var(--form-bg-color)">
                                            <form action="{{ route('frames.attach_frame', $frame) }}" method="post">
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
                                Cages
                            </div>
                            <div class="col">
                                <button type="button" class="btn  ml-3 btn-primary collapsed"data-bs-toggle="collapse"
                                    data-bs-target="#addCageCollapse"> Assign New Cage </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="editModal-{{ $frame->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Frame</h5>
                        <button type="button" style="background-color:red" class="btn-close  btn-danger"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        @include('includes.edit_frame_form')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            @if (session('modalOpen'))
                $('#editFrameModal').addClass('show');
            @endif
        });
    </script>
@endsection
