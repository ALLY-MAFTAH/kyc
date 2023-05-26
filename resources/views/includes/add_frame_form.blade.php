<form action="{{ route('frames.add') }}" method="POST">
    @csrf
    <div class="row">
        <input type="number" name="market_id" value="{{ $market->id }}" hidden>

        <div class="col-md-3 form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" value="{{$newFrameCode}}" id="code" placeholder="Code"required autocomplete="code"
                value="{{ old('code') }}" name="newCode" />
            @error('code')
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
            <label for="size">Frame Size</label>
            <input type="text" class="form-control" id="size" autocomplete="size" placeholder="Size (Optional)"
                value="{{ old('size') }}" name="size" /> @error('size')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 form-group">
            <label for="count">Number of Frames</label>
            <input type="number" class="form-control" value="1" id="count" autocomplete="count" min="1"
                value="{{ old('count') }}" name="count" /> @error('count')
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
