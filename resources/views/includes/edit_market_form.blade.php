<form action="{{ route('markets.edit', $market) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="code">Code</label>
        <input type="text" class="form-control" id="code" autofocus
            value="{{ old('code', $market->code) }}" placeholder="Code"required
            autocomplete="code" name="code" />
        @error('code')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name"
            value="{{ old('name', $market->name) }}" placeholder="Name"required
            autocomplete="name" name="name" /> @error('name')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="ward">Ward</label>
        <div id="wards">
            <input class="typeahead" id="ward" type="text"
                value="{{ old('ward', $market->ward) }}" placeholder="Ward"required
                autocomplete="ward" name="ward" /> @error('ward')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="street">Sub-Ward</label>
        <div id="streets">
            <input type="text" class="typeahead" id="street"
                value="{{ old('sub_ward', $market->sub_ward) }}" name="sub_ward"
                autocomplete="street" placeholder="Sub-Ward"required /> @error('sub_ward')
                <span class="error" style="color:red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="manager_name">Manager Name</label>
        <input type="text" class="form-control" id="manager_name"
            value="{{ old('manager_name', $market->manager_name) }}" autocomplete="name"
            placeholder="Mnager Name"required name="manager_name" /> @error('manager_name')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="manager_mobile">Manager Mobile</label>
        <input type="number" class="form-control" id="manager_mobile"autocomplete="phone"
            value="{{ old('manager_mobile', $market->manager_mobile) }}"
            placeholder="Eg; 0712345678" maxlength="10" pattern="0[0-9]{9}"required
            name="manager_mobile" />
        @error('manager_mobile')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="size">Market Size</label>
        <input type="text" class="form-control" id="size"
            value="{{ old('size', $market->size) }}" autocomplete="size"
            placeholder="Size (Optional)" name="size" /> @error('size')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Market Sections</label>
        <div>
            <select class="js-example-basic-multiple form-control" multiple="multiple" required
                name="sections[]" style="width: 100%;">
                @php
                    $selectedSections = old('sections', $market->sections->pluck('name')->toArray());
                @endphp

                @foreach ($market->sections as $section)
                    <option value="{{ $section->name }}"
                        {{ in_array($section, $selectedSections) ? 'selected' : '' }}>
                        {{-- {{ $section->name }} --}}
                    </option>
                @endforeach
                <option value="Ground"
                    {{ in_array('Ground', $selectedSections) ? 'selected' : '' }}>
                    Ground</option>
                <option value="Ground Floor"
                    {{ in_array('Ground Floor', $selectedSections) ? 'selected' : '' }}>
                    Ground Floor</option>
                <option value="First Floor"
                    {{ in_array('First Floor', $selectedSections) ? 'selected' : '' }}>
                    First Floor</option>
                <option value="Second Floor"
                    {{ in_array('Second Floor', $selectedSections) ? 'selected' : '' }}>
                    Second Floor</option>
                <option value="Third Floor"
                    {{ in_array('Third Floor', $selectedSections) ? 'selected' : '' }}>
                    Third Floor</option>
                <option value="First Wing"
                    {{ in_array('First Wing', $selectedSections) ? 'selected' : '' }}>
                    First Wing</option>
                <option value="Second Wing"
                    {{ in_array('Second Wing', $selectedSections) ? 'selected' : '' }}>
                    Second Wing</option>
                <option value="Third Wing"
                    {{ in_array('Third Wing', $selectedSections) ? 'selected' : '' }}>
                    Third Wing</option>
                <option value="Left Wing"
                    {{ in_array('Left Wing', $selectedSections) ? 'selected' : '' }}>
                    Left Wing</option>
                <option value="Right Wing"
                    {{ in_array('Right Wing', $selectedSections) ? 'selected' : '' }}>
                    Right Wing</option>
                <option value="Central Wing"
                    {{ in_array('Central Wing', $selectedSections) ? 'selected' : '' }}>
                    Central Wing</option>
                <option value="Inside"
                    {{ in_array('Inside', $selectedSections) ? 'selected' : '' }}>
                    Inside</option>
                <option value="Outside"
                    {{ in_array('Outside', $selectedSections) ? 'selected' : '' }}>
                    Outside</option>
                <option value="Upper"
                    {{ in_array('Upper', $selectedSections) ? 'selected' : '' }}>
                    Upper</option>
                <option value="Down"
                    {{ in_array('Down', $selectedSections) ? 'selected' : '' }}>
                    Down</option>
                <option value="Underground"
                    {{ in_array('Underground', $selectedSections) ? 'selected' : '' }}>
                    Underground</option>
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
