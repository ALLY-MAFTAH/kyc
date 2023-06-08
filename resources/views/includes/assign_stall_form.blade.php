<form action="{{ route('customers.attach_stall', $customer) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-7 form-group">
            <label for="">Stall</label>
            <select class="js-example-basic-single form-control" required
                name="stall_id" style="width: 100%;">
                <option value=""> -- </option>
                @foreach ($emptyStalls as $stall)
                    <option value={{ $stall->id }}>
                        {{ $stall->code }} &nbsp;&nbsp;
                        ({{ $stall->location }})
                    </option>
                @endforeach
            </select>
            @error('stall_id')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5 form-group">
            <label for="">Month</label>
            <select class="js-example-basic-multiple form-control"
                aria-placeholder="Month" multiple="multiple" required name="months[]"
                style="width: 100%;">
                <option value="">Month</option>
                <option value="January">January &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="February">February
                    &nbsp;&nbsp;{{ date('Y') }}</option>
                <option value="March">March &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="April">April &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="May">May &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="June">June &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="July">July &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="August">August &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="September">September
                    &nbsp;&nbsp;{{ date('Y') }}</option>
                <option value="October">October &nbsp;&nbsp;{{ date('Y') }}
                </option>
                <option value="November">November
                    &nbsp;&nbsp;{{ date('Y') }}</option>
                <option value="December">December
                    &nbsp;&nbsp;{{ date('Y') }}</option>
            </select>
            @error('months[]')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 form-group">
            <label for="">Business</label>
            <input type="text" name="business" class="form-control"
                placeholder="Business (Optional)">
            @error('business')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5 form-group">
            <label for="">Receipt Number</label>
            <input type="text" name="receipt_number" class="form-control"
                placeholder="Receipt Number" required>
            @error('receipt_number')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mb-2 mt-2">
        <div class="text-center">
            <button type="submit" class="btn  btn-outline-primary">
                {{ __('Assign') }}
            </button>
        </div>
    </div>
</form>
