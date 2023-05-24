<form action="{{ route('frames.edit', $frame) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <input type="number" name="market_id" value="{{ $market->id }}" hidden>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" placeholder="Code"required autocomplete="code"
                value="{{ old('code', $frame->code) }}" name="code" />
            @error('code')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Location</label>
            <select class="js-example-basic-single form-control" required name="location" style="width: 100%;">
                @foreach ($market->sections as $section)
                    <option value="{{ $section->name }}" {{ $section->name == $frame->location ? 'selected' : '' }}>
                        {{ $section->name }}</option>
                @endforeach
            </select>
            @error('location')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-group">
            <label for="size">Frame Size</label>
            <input type="text" class="form-control" id="size" autocomplete="size" placeholder="Size (Optional)"
                value="{{ old('size', $frame->size) }}" name="size" /> @error('size')
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
