@extends('layouts.app')

@section('title')
    {{ $market->name }} | Customer
@endsection

@section('content')
@section('breadcrumbs')
    <div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a style="text-decoration:none" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"
                        style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <a style="text-decoration:none" href="{{ route('markets.index') }}">Markets</a>
                <i class="mdi mdi-chevron-right"></i>
                <a style="text-decoration:none" href="{{ route('markets.show', $market) }}">{{ $market->name }}</a>
                <i class="mdi mdi-chevron-right"></i>
                <span style="font-size:15px">Customer: {{ $customer->first_name }} {{ $customer->middle_name }}
                    {{ $customer->last_name }}</span>
            </h4>
        </div>
        <div class="d-flex ">
            <div class="d-flex ">
                <button onclick="saveWebpage()" type="button" class="btn  bg-white btn-icon-text border">
                    <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
                <button onclick="printDiv('printable-content')"  type="button" class="btn  bg-white btn-icon-text border ml-3">
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
<div class="page-wrapper mdc-toolbar-fixed-adjust">

    <div class="row">
        <div class="col-md-6 pb-2">
            <div class="card shadow px-2">
                <div class="row">
                    <div class="col-md-3 text-center leftProfSide">
                        <div class="my-3 mx-2 text-center"
                            style="width: 130px; height: 130px; overflow: hidden; border-radius: 50%; border: 1px solid rgb(0, 132, 255);">
                            <img src="{{ asset('storage/' . $customer->photo) }}" alt="" style="width: 100%;"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/user.png') }}';">
                        </div>
                        <div class="contBtns py-3 ml-2 ">
                            <button href="#" data-bs-toggle="modal"
                                data-bs-target="#messageModal-{{ $customer->id }}"
                                class=" text-center btn btn-outline-primary" type="button"><i
                                    class="mdi mdi-message-processing" style=""></i>MESSAGE</button>
                        </div>
                    </div>
                    <div class="col-md-9  py-2">
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
                            STALLS
                        </div>
                    </div>
                    <div class="col text-center"style="">
                        <i class="mdi mdi-cash-usd" style="font-size: 40px;color:rgb(32, 12, 251)"></i>
                        <div class="py-3">
                            <b>{{ number_format($payments->sum('amount'), 0, '.', ',') }}</b> TZS

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
                    <div id="assignFrameCollapse" style="width: 100%;border-width:0px"
                        class="accordion-collapse collapse" aria-labelledby="assignFrameCollapse"
                        data-parent="#assignFrameCollapse">
                        <div class="accordion-body">
                            <div class="text-center" style="color:gray">Assign Frame</div>
                            <div class="card p-2 mt-2" style="background: var(--form-bg-color)">
                                @include('includes.assign_frame_form')

                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row ">
                        @forelse ($customerFrames as $frame)
                            <div class="col-md-6 pl-1 pr-1">
                                <div class="card shadow mt-2">
                                    <div class="card-header d-flex justify-content-between align-items-center"
                                        style="padding:2px;padding-left:5px;color:rgb(3, 3, 113)">
                                        <span style="font-size: 15px">Code: <b>{{ $frame->code }}</b></span>
                                        <a href="{{ route('customers.detach_frame', ['customer' => $customer, 'frameId' => $frame->id]) }}"
                                            onclick="return confirm('Are you sure you want to unassign this frame from this customer?');"
                                            class="">
                                            <i class="mdi mdi-delete-forever" style="color:red;font-size:30px"></i>
                                        </a>
                                    </div>
                                    <div class="card-body" style="padding: 6px; font-size:13px">
                                        <div>Location: <span
                                                style="color:rgb(4, 4, 141)">{{ $frame->location }}</span>
                                        </div>
                                        <div>Entry Date: <span style="color:rgb(4, 4, 141)">
                                                {{ Illuminate\Support\Carbon::parse($frame->entry_date)->format('D, d M Y') }}
                                            </span>
                                        </div>
                                        <div>Price: <span
                                                style="color:rgb(4, 4, 141)">{{ number_format($frame->price, 0, '.', ',') }}
                                                TZS</span></div>
                                        <div>Business: <span
                                                style="color:rgb(4, 4, 141)">{{ $frame->business }}</span></div>
                                        <div>Size: <span style="color:rgb(4, 4, 141)">{{ $frame->size }}</span></div>
                                        <div>Issued By: <span
                                                style="color:rgb(4, 4, 141)">{{ $frame->user->name ?? '' }}</span>
                                        </div>
                                        <div class="py-2 text-right">
                                            <form id="showFrameRecord-{{ $frame->id }}"
                                                action="{{ route('customers.show', ['customer' => $frame->customer, 'marketId' => $market->id]) }}"
                                                method="get">
                                                <input type="number" value="{{ $frame->id }}"
                                                    name="selectedFrameId" hidden>
                                                <input type="number" value="{{ $selectedStallId }}"
                                                    name="selectedStallId" hidden>
                                                <input type="number" value="{{ $frameSelectedYear }}"
                                                    name="frameSelectedYear" hidden>
                                                <input type="number" value="{{ $stallSelectedYear }}"
                                                    name="stallSelectedYear" hidden>
                                                <button href="#" data-id="{{ $frame->id }}" type="submit"
                                                    class="btn-outline-warning btn" type="button">Show
                                                    Records</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="text-gray text-center pt-2" style="font-size: 13px"> 0 Frames</div>
                        @endforelse
                    </div>

                </div>
                @if ($customerFrames->count() != 0)
                    @include('includes.frame_records')
                @endif
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
                    <div id="assignStallCollapse" style="width: 100%;border-width:0px"
                        class="accordion-collapse collapse" aria-labelledby="assignStallCollapse"
                        data-parent="#assignStallCollapse">
                        <div class="accordion-body">
                            <div class="text-center" style="color:gray">Assign Stall</div>
                            <div class="card p-2 mt-2" style="background: var(--form-bg-color)">
                                @include('includes.assign_stall_form')
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($customerStalls as $stall)
                            <div class="col-md-6 pl-1 pr-1">
                                <div class="card shadow mt-2">
                                    <div class="card-header d-flex justify-content-between align-items-center"
                                        style="padding:2px;padding-left:5px;color:rgb(3, 3, 113)">
                                        <span style="font-size: 15px">Code: <b>{{ $stall->code }}</b></span>
                                        <a href="{{ route('customers.detach_stall', ['customer' => $customer, 'stallId' => $stall->id]) }}"
                                            onclick="return confirm('Are you sure you want to unassign this stall from this customer?');"
                                            class="">
                                            <i class="mdi mdi-delete-forever" style="color:red;font-size:30px"></i>
                                        </a>
                                    </div>
                                    <div class="card-body" style="padding: 6px; font-size:13px">
                                        <div class="row">
                                            <div class="col-8">
                                                <div>Location: <span
                                                        style="color:rgb(4, 4, 141)">{{ $stall->location }}</span>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div
                                                    style="padding-right:5px;font-size:12px;color:rgb(70, 63, 111);background:rgb(201, 198, 198)">
                                                    {{ $stall->type }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>Entry Date: <span style="color:rgb(4, 4, 141)">
                                                {{ Illuminate\Support\Carbon::parse($stall->entry_date)->format('D, d M Y') }}
                                            </span>
                                        </div>
                                        <div>Price: <span
                                                style="color:rgb(4, 4, 141)">{{ number_format($stall->price, 0, '.', ',') }}
                                                TZS</span></div>
                                        <div>Business: <span
                                                style="color:rgb(4, 4, 141)">{{ $stall->business }}</span></div>
                                        <div>Size: <span style="color:rgb(4, 4, 141)">{{ $stall->size }}</span>
                                        </div>
                                        <div>Issued By: <span
                                                style="color:rgb(4, 4, 141)">{{ $stall->user->name ?? ('' ?? '') }}</span>
                                        </div>
                                        <div class="py-2 text-right">
                                            <form id="showStallRecord-{{ $stall->id }}"
                                                action="{{ route('customers.show', ['customer' => $stall->customer, 'marketId' => $market->id]) }}"
                                                method="get">
                                                <input type="number" value="{{ $stall->id }}"
                                                    name="selectedStallId" hidden>
                                                <input type="number" value="{{ $selectedFrameId }}"
                                                    name="selectedFrameId" hidden>
                                                <input type="number" value="{{ $stallSelectedYear }}"
                                                    name="stallSelectedYear" hidden>
                                                <input type="number" value="{{ $frameSelectedYear }}"
                                                    name="frameSelectedYear" hidden>
                                                <button href="#" data-id="{{ $stall->id }}" type="submit"
                                                    class="btn-outline-warning btn" type="button">Show
                                                    Records</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray text-center pt-2" style="font-size: 13px"> 0 Stalls</div>
                        @endforelse
                    </div>
                </div>
                @if ($customerStalls->count() != 0)
                    @include('includes.stall_records')
                @endif
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
    <div class="modal fade" id="messageModal-{{ $customer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message
                    </h5>
                    <button type="button" style="background-color:red" class=" btn-danger btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('send-message', $customer) }}">
                        @csrf
                        <div class="text-start mb-1">
                            <label for="body" class="col-form-label text-sm-start">{{ __('Body') }}</label>
                            <textarea rows="3" id="body" type="text" placeholder="Body"
                                class="form-control @error('body') is-invalid @enderror" name="body" autocomplete="body" required autofocus></textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-1 pt-2 mt-2">
                            <div class="text-center">
                                <button type="submit" class="btn  btn-outline-primary">
                                    {{ __('Send Message') }}
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
<script>
    function captureImage() {
        // Access the camera and capture video stream
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                var video = document.createElement('video');
                var canvas = document.getElementById('canvas');
                var context = canvas.getContext('2d');

                // Play the video stream in the video element
                video.srcObject = stream;
                video.play();

                // When the video is playing, capture a frame from the video stream
                video.addEventListener('play', function() {
                    var size = Math.min(video.videoWidth, video.videoHeight);
                    canvas.width = size;
                    canvas.height = size;

                    // Calculate the offset to center the video frame within the canvas
                    var xOffset = (video.videoWidth - size) / 2;
                    var yOffset = (video.videoHeight - size) / 2;

                    // Draw the video frame onto the canvas
                    function drawFrame() {
                        context.drawImage(video, xOffset, yOffset, size, size, 0, 0, size, size);
                        requestAnimationFrame(drawFrame);
                    }
                    drawFrame();
                });
            })
            .catch(function(error) {
                console.log('Error accessing the camera: ', error);
            });
    }
</script>
@endsection
