@extends('layouts.app')
@section('styles')
@endsection

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-2"> Markets</h3>
        <div class="d-flex">
            <button type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
            <button type="button" class="btn  ml-3 btn-primary collapsed"data-bs-toggle="collapse"
                data-bs-target="#addMarket"> Create Market </button>
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
    <div class="card">
        <div class="card-header">Markets
        </div>
        <div class="card-body">
            <div id="addMarket" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="addMarket" data-bs-parent="#addMarket">
                <div class="accordion-body">
                    <div class="text-center" style="color:gray">Create Market</div>
                    <div class="card p-2 mt-1" style="background: var(--form-bg-color)">
                        <form action="{{ route('markets.add') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="number">Number</label>
                                    <input type="text" class="form-control" id="number" placeholder="Number"required
                                        autocomplete="number" name="number" /> @error('number')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Name"required
                                        autocomplete="name" name="name" /> @error('name')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="ward">Ward</label>
                                    <div id="wards">
                                        <input class="typeahead" id="ward" type="text" placeholder="Ward"required
                                            autocomplete="ward" name="ward" /> @error('ward')
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
                                        placeholder="Mnager Name"required name="manager_name" /> @error('manager_name')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="manager_mobile">Manager Mobile</label>
                                    <input type="number" class="form-control" id="manager_mobile"autocomplete="phone"
                                        placeholder="Eg; 0712345678" maxlength="10" pattern="0[0-9]{9}"required
                                        name="manager_mobile" /> @error('manager_mobile')
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
                                    <select class="js-example-basic-multiple form-control" multiple="multiple" required
                                        name="sections[]" style="width: 100%;">
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
            <table class="table table-responsive">
                <thead class="table-header">
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Ward</th>
                        <th>Street</th>
                        <th>Manager Name</th>
                        <th>Manager Phone</th>
                        <th>Size</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($markets as $index => $market)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $market->number }}</td>
                            <td>{{ $market->name }}</td>
                            <td>{{ $market->ward }}</td>
                            <td>{{ $market->street }}</td>
                            <td>{{ $market->manager_name }}</td>
                            <td>{{ $market->manager_mobile }}</td>
                            <td>{{ $market->size }}</td>
                            <td class="text-center">
                                <a href="{{ route('markets.show', $market) }}" class="btn  btn-outline-info collapsed"
                                    type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
                                {{-- <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                    data-toggle="modal" data-target="#editModal-{{ $market->id }}"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="feather icon-edit"></i> Edit
                                </a> --}}
                                <a href="#" class="btn  btn-outline-danger"
                                    onclick="if(confirm('Are you sure want to delete {{ $market->name }}?')) document.getElementById('delete-market-{{ $market->id }}').submit()">
                                    <i class="f"></i>Delete
                                </a>
                                <form id="delete-market-{{ $market->id }}" method="post"
                                    action="{{ route('markets.delete', $market) }}">
                                    @csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
