<form action="{{ route('cages.add') }}" method="POST">
    @csrf
    <div class="row">
        <input type="number" name="market_id" value="{{ $market->id }}" hidden>
        <div class="col-md-3 form-group">
            <label for="number">Number</label>
            <input type="text" class="form-control" id="number" value="{{ old('number') }}"
                placeholder="Number"required autocomplete="number" name="number" />
            @error('number')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 form-group">
            <label>Location</label>
            <select class="js-example-basic-single form-control" required name="location" style="width: 100%;">
                <option value="">-- Select Location --</option>
                @foreach ($market->sections as $section)
                    <option value="{{ old('location', $section->name) }}">{{ $section->name }}</option>
                @endforeach
            </select>
            @error('location')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 form-group">
            <label>Type</label>
            <select class="js-example-basic-single form-control" required name="type" style="width: 100%;">
                <option value="">-- Select Type --</option>
                <option value="Imaginary">Imaginary</option>
                <option value="Real">Real</option>
            </select>
            @error('type')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 form-group">
            <label for="size">Cage Size</label>
            <input type="text" class="form-control" id="size" autocomplete="size" value="{{ old('size') }}"
                placeholder="Size (Optional)" name="size" /> @error('size')
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
