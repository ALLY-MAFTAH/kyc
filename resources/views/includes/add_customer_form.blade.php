 <form action="{{ route('customers.add') }}" method="POST" enctype="multipart/form-data">
     @csrf
     <input type="number" name="market_id" value="{{ $market->id }}" hidden>
     <div class="row">
         <div class="col-md-3 form-group">
             <label for="first_name">First Name</label>
             <input type="text" class="form-control" id="first_name" placeholder="First Name"required
                 value="{{ old('first_name') }}" autocomplete="first_name" name="first_name" />
             @error('first_name')
                 <span class="error" style="color:red">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-3 form-group">
             <label for="middle_name">Middle Name</label>
             <input type="text" class="form-control" id="middle_name" placeholder="Middle Name (Optional)"
                 value="{{ old('middle_name') }}" autocomplete="middle_name" name="middle_name" />
             @error('middle_name')
                 <span class="error" style="color:red">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-3 form-group">
             <label for="last_name">Last Name</label>
             <input type="text" class="form-control" id="last_name" placeholder="Last Name"required
                 value="{{ old('last_name') }}" autocomplete="surname" name="last_name" />
             @error('last_name')
                 <span class="error" style="color:red">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-3 form-group">
             <label for="photo">Profile Picture</label>
             <input type="file" name="photo" class="file-upload-default" />
             <div class="input-group col-xs-12">
                 <input type="text" class="form-control file-upload-info" disabled placeholder="Capture Image" />
                 <span class="input-group-append">
                     <button class="file-upload-browse bstn btn-primary" type="button"
                         onclick="captureImage()">Capture</button>
                 </span>
             </div>
         </div>
         <canvas id="canvas" style="display: none;"></canvas>
     </div>
     <div class="row">
         <div class="col-md-4 form-group">
             <label for="nida">NIDA</label>
             <input type="number" class="form-control" id="nida" value="{{ old('nida') }}" autocomplete="name"
                 placeholder="NIDA"required name="nida" /> @error('nida')
                 <span class="error" style="color:red">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-4 form-group">
             <label for="mobile">Mobile Number</label>
             <input type="number" class="form-control" id="mobile" value="{{ old('mobile') }}" autocomplete="phone"
                 placeholder="Eg; 0712345678" maxlength="10" pattern="0[0-9]{9}"required name="mobile" />
             @error('mobile')
                 <span class="error" style="color:red">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-4 form-group">
             <label for="address">Physical Address</label>
             <input type="text" class="form-control" id="address" value="{{ old('address') }}"
                 autocomplete="address" placeholder="Address (Optional)" name="address" /> @error('address')
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
