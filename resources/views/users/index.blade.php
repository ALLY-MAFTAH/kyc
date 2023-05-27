@extends('layouts.app')

@section('title')
    Users
@endsection

@section('breadcrumbs')
<div class="page-header flex-wrap">
        <div class="breadcrumbs-item">
            <h4 class="mb-2">
                <a href="{{ route('home') }}"><i class="mdi mdi-home menu-icon" style="font-size:25px"></i></a>
                <i class="mdi mdi-chevron-right"></i>
                <span>Users</span>
            </h4>
        </div>
        <div class="d-flex ">
            <button type="button" class="btn  bg-white btn-icon-text border">
                <i class="mdi mdi-download btn-icon-prepend"></i> Download </button>
            <button type="button" class="btn  bg-white btn-icon-text border ml-3">
                <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
        </div>
    </div>
    @endsection
<br>
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

    <div class="card shadow">
        <div class="card-header">Users
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('users.add') }}">
                            @csrf
                            <div class="row">
                                <div class="col mb-1">
                                    <label for="market_id" class=" col-form-label text-sm-start">{{ __('Market') }}</label>
                                    <span class="text-danger"> *</span>
                                    <select id="market_id" type="text"
                                        class="form-control form-select @error('market_id') is-invalid @enderror"
                                        name="market_id" value="{{ old('market_id') }}" required autocomplete="market_id"
                                        autofocus>
                                        <option value="">Choose Market</option>
                                        @foreach ($markets as $market)
                                            <option value="{{ $market->id }}">{{ $market->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('market_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}
                                    </label> <span class="text-danger"> *</span>
                                    <div class="">
                                        <input id="name" type="text" placeholder="Name"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}"required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col mb-1">
                                    <label for="email"
                                        class=" col-form-label text-sm-start">{{ __('Email Address') }}</label>
                                    <span class="text-danger"> *</span>
                                    <div class="">
                                        <input id="email" type="text" placeholder="me@me.com"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 mt-2">
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
            <div class="table-responsive-lg">
                <table id="data-tebo1" class="dt-responsive nowrap shadow rounded-3  table table-hover"style="width: 100%">
                    <thead class=" table-head">
                        <tr>
                            <th class="text-center" style="max-width: 20px">#</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            {{-- <th class="text-center">Status</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    @if ($user->market_id)
                                        MANAGER - {{ $user->market->name }}
                                    @else
                                        SUPER ADMIN
                                    @endif
                                </td>
                                {{-- <td class="text-center">
                                            <form id="toggle-status-form-{{ $user->id }}" method="POST"
                                                action="{{ route('users.toggle-status', $user) }}">
                                                <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                                                    <div class="mdc-switch__track"></div>
                                                    <div class="mdc-switch__thumb-underlay">
                                                        <div class="mdc-switch__thumb">
                                                            <input type="hidden" name="status" value="0">
                                                            <input type="checkbox" name="status"
                                                                id="bassic-status-switch-{{ $user->id }}"@if ($user->status) checked @endif
                                                                class="mdc-switch__native-control" market="switch"
                                                                value="1" onclick="this.form.submit()" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </td> --}}
                                <td class="text-center ">
                                    @if ($user->market_id)
                                        <a href="#" class="btn  btn-outline-primary mx-2" type="button"
                                            data-toggle="modal" data-target="#editUserModal-{{ $user->id }}"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Edit
                                        </a>

                                        <a href="#" class="btn  btn-outline-danger mx-2"
                                            onclick="if(confirm('Are you sure want to delete {{ $user->name }}?')) document.getElementById('delete-user-{{ $user->id }}').submit()">
                                            Delete
                                        </a>
                                        <form id="delete-user-{{ $user->id }}" method="post"
                                            action="{{ route('users.delete', $user) }}">@csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                </td>

                                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit User
                                                </h5>
                                                <button type="button" class=" btn-danger  btn-close"
                                                    data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('users.edit', $user) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="text-start mb-1">
                                                        <label for="name"
                                                            class="col-form-label text-sm-start">{{ __('Name') }}</label>
                                                        <input id="name" type="text" placeholder="Name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" value="{{ old('name', $user->name) }}"
                                                            required autocomplete="name" autofocus>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="text-start mb-1">
                                                        <label class="col-form-label" for="mobile">Mobile
                                                            Number</label>
                                                        <input type="number" class="form-control"
                                                            id="mobile"autocomplete="phone"
                                                            value="{{ old('mobile', $user->mobile) }}"
                                                            placeholder="Eg; 0712345678" maxlength="10"
                                                            pattern="0[0-9]{9}"required name="mobile" />
                                                        @error('mobile')
                                                            <span class="error" style="color:red">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="text-start mb-1">
                                                        <label for="email"
                                                            class="col-form-label text-sm-start">{{ __('Email Address') }}</label>
                                                        <input id="email" type="text" placeholder="me@me.go.tz"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email', $user->email) }}"
                                                            autocomplete="email" autofocus>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="text-start mb-1">
                                                        <label class="col-form-label" for="">Market</label>
                                                        <select class="js-example-basic-single form-control" required
                                                            name="market_id" style="width: 100%;">

                                                            @foreach ($markets as $market)
                                                                <option value={{ $market->id }}
                                                                    {{ $market->id == $user->market_id ? 'selected' : '' }}>
                                                                    {{ $market->code }} &nbsp;-&nbsp;
                                                                    {{ $market->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('market_id')
                                                            <span class="error" style="color:red">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="row mb-1 pt-3">
                                                        <div class="text-center">
                                                            <button type="submit" class="btn  btn-primary">
                                                                {{ __('Submit') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
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
@endsection
@section('scripts')
@endsection
