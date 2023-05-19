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
            <div class="col-md-7 pb-2">
                <div class="card shadow px-2">
                    <div class="row">
                        <div class="col-md-9  py-2">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">Number: </div>
                                            <div style="color:rgb(188, 186, 186)">Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Ward: </div>
                                            <div style="color:rgb(188, 186, 186)">Street: </div>
                                            <div style="color:rgb(188, 186, 186)">Manager Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Manager Phone: </div>
                                            <div style="color:rgb(188, 186, 186)">Size: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div style="color:rgb(3, 3, 87)">{{ $market->number }}</div>
                                            <div>{{ $market->name }}</div>
                                            <div>{{ $market->ward }}</div>
                                            <div>{{ $market->street }}</div>
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
                                        <div class="pt-4">
                                            <button href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal-{{ $market->id }}"
                                                class="btn-outline-primary btn" type="button">EDIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  py-2">
                            <div class="card p-1" style="background-color:rgba(189, 214, 237, 0.396)">
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
            <div class="col-md-5 pb-2">
                <div class="card shadow">
                    <div class="card-header text-center">Summary</div>
                    <div class="row px-2 pt-2">
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
        <div class="card">
            <div class="card-header  text-center" style="font-size: 20px">
                <div class="row">
                    <div class="col">
                        Frames
                    </div>
                    <div class="col">
                        <button type="button" class="btn  ml-3 btn-primary collapsed"data-bs-toggle="collapse"
                            data-bs-target="#addFrame"> Add Frame </button>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div id="addFrame" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                    aria-labelledby="addFrame" data-bs-parent="#addFrame">
                    <div class="accordion-body">
                        <div class="text-center" style="color:gray">Add Frame</div>
                        <div class="card p-2 mt-1" style="background: var(--form-bg-color)">
                            <form action="{{ route('frames.add') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="number">Number</label>
                                        <input type="text" class="form-control" id="number"
                                            placeholder="Number"required autocomplete="number" name="number" />
                                        @error('number')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Name"required autocomplete="name" name="name" />
                                        @error('name')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="ward">Ward</label>
                                        <div id="wards">
                                            <input class="typeahead" id="ward" type="text"
                                                placeholder="Ward"required autocomplete="ward" name="ward" />
                                            @error('ward')
                                                <span class="error" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="street">Street</label>
                                        <div id="streets">
                                            <input type="text" class="typeahead" id="street" name="street"
                                                autocomplete="street" placeholder="Street"required /> @error('street')
                                                <span class="error" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="manager_name">Manager Name</label>
                                        <input type="text" class="form-control" id="manager_name" autocomplete="name"
                                            placeholder="Mnager Name"required name="manager_name" />
                                        @error('manager_name')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="manager_mobile">Manager Mobile</label>
                                        <input type="number" class="form-control"
                                            id="manager_mobile"autocomplete="phone" placeholder="Eg; 0712345678"
                                            maxlength="10" pattern="0[0-9]{9}" required name="manager_mobile" />
                                        @error('manager_mobile')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="size">Market Size</label>
                                        <input type="text" class="form-control" id="size" autocomplete="size"
                                            placeholder="Size (Optional)" name="size" /> @error('size')
                                            <span class="error" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Market Sections</label>
                                        <select class="js-example-basic-multiple form-control" multiple="multiple"
                                            required name="sections[]" style="width: 100%;">
                                            <option value="General">General</option>
                                            <option value="Ground Floor">Ground Floor</option>
                                            <option value="First Floor">First Floor</option>
                                            <option value="Second Floor">Second Floor</option>
                                            <option value="Third Floor">Third Floor</option>
                                            <option value="First Wing">First Wing</option>
                                            <option value="Second Wing">Second Wing</option>
                                            <option value="Third Wing">Third Wing</option>
                                            <option value="Left Wing">Left Wing</option>
                                            <option value="Right Wing">Right Wing</option>
                                            <option value="Central Wing">Central Wing</option>
                                            <option value="Inside">Inside</option>
                                            <option value="Outside">Outside</option>
                                            <option value="Upper">Upper</option>
                                        </select> @error('selections')
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
                        <br>
                    </div>
                </div>
                <div class="table-responsive-lg">
                    <table id="data-tebo1"
                        class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                        <thead class=" table-head">
                            <tr>
                                <th class="text-center" style="max-width: 20px">#</th>
                                <th>Number</th>
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
                                    <td>{{ $frame->number }}</td>
                                    <td> {{ $frame->section }} </td>
                                    <td> {{ $frame->price }} </td>
                                    <td class="text-center">
                                        <a href="{{ route('frames.show') }}" class="btn  btn-outline-info"
                                            type="button">
                                            View
                                        </a>
                                        <a href="#" class="btn  btn-outline-danger"
                                            onclick="if(confirm('Are you sure want to delete frame number: {{ $frame->number }}?')) document.getElementById('delete-frame-{{ $frame->id }}').submit()">
                                            Delete
                                        </a>
                                        <form id="delete-frame-{{ $frame->id }}" method="post"
                                            action="{{ route('frames.delete', $frame) }}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal-{{ $market->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Market</h5>
                        <button type="button" style="background-color:red" class="btn-close btn btn-danger"
                            data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        @include('includes.edit_market_form')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
@endsection
