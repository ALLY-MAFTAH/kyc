<form action="{{ route('customers.edit', $customer) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" autofocus
            value="{{ old('first_name', $customer->first_name) }}" placeholder="First Name"required
            autocomplete="first_name" name="first_name" />
        @error('first_name')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" class="form-control" id="middle_name" autofocus
            value="{{ old('middle_name', $customer->middle_name) }}" placeholder="Middle Name"
            autocomplete="middle_name" name="middle_name" />
        @error('middle_name')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" autofocus
            value="{{ old('last_name', $customer->last_name) }}" placeholder="Last Name"required
            autocomplete="last_name" name="last_name" />
        @error('last_name')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="nida">NIDA</label>
        <input type="number" class="form-control" id="nida"autocomplete="nida"
            value="{{ old('nida', $customer->nida) }}"
            pattern="0[0-9]{9}"required name="nida" />
        @error('nida')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="mobile">Mobile Number</label>
        <input type="number" class="form-control" id="mobile"autocomplete="phone"
            value="{{ old('mobile', $customer->mobile) }}" placeholder="Eg; 0712345678" maxlength="10"
            pattern="0[0-9]{9}"required name="mobile" />
        @error('mobile')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" value="{{ old('address', $customer->address) }}"
            autocomplete="address" placeholder="Address (Optional)" name="address" /> @error('address')
            <span class="error" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="row mb-2 mt-2">
        <div class="text-center">
            <button type="submit" class="btn  btn-outline-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>
