<div class="card-body p-4">
    <div class="text-center w-75 m-auto">
        <a href="{{ route('login') }}">
            <span><img src="{{ asset('images/sinag.png') }}" alt="" height="120"></span>
        </a>
        <p class="text-muted mb-4 mt-3">Want to get a quotation? Create your account, it takes less than a minute</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype='multipart/form-data'>
        {{ csrf_field() }}
        <input name="status" type="hidden" id="status" value="pending">
        <input name="alignment" type="hidden"  id="alignment" value="request">
        <input name="site_visit" type="hidden" id="site_visit" value="waiting">
        <!-- Client Role -->
        <input name="role_id" type="hidden" id="role_id" value="3">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input class="form-control" type="text" name="first_name" id="firstname" value="{{ old('firstname') }}" placeholder="Enter your first name" required>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input class="form-control" type="text" name="last_name" id="lastname" value="{{ old('lastname') }}" placeholder="Enter your last name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input class="form-control" name="email" type="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input class="form-control" name="mobile_number" type="text" id="phone" value="{{ old('phone') }}" pattern="[0-9]{11}" placeholder="Enter your 11-digit number" required>
        </div>
        <div class="form-group">
            <label for="street">Street</label>
            <input class="form-control" name="street" type="text" id="street" value="{{ old('street') }}" placeholder="Enter your street" required>
        </div>
        <div class="form-group">
            <label for="barangay">Barangay</label>
            <input class="form-control" name="barangay" type="text" id="barangay" value="{{ old('barangay') }}" placeholder="Enter your barangay" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input class="form-control" name="city" type="text" id="city" value="{{ old('city') }}" placeholder="Enter your city" required>
        </div>
        <div class="form-group">
            <label for="province">Province</label>
            <input class="form-control" name="province" type="text" id="province" value="{{ old('province') }}" placeholder="Enter your province" required>
        </div>
        <div class="form-group">
            <label for="zip">Zip</label>
            <input class="form-control" name="zip" type="text" id="zip" value="{{ old('zip') }}" placeholder="Enter your zip code">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="average_bill">Average Bill</label>
                <input class="form-control" type="number" min="500" name="average_bill" id="average_bill" value="{{ old('average_bill') }}" placeholder="Enter your average bill" required>
            </div>
            <div class="form-group col-md-6">
                <label for="upload_bill">Upload Bill</label>
                <input class="form-control" type="file" name="image" value="{{ old('image') }}" id="upload_bill" required>
            </div>
        </div>
        <div class="form-group">
            <label for="goal">Goal</label>
            <select required name="goal" id="goal" value="{{ old('goal') }}" class="form-control">
                <option value="full">Full Bill (Zero Bill)</option>
                <option value="half">Half Bill (Half of the current bill)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name="password" type="password" id="password" minlength="6" placeholder="Enter your password" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirm Password</label>
            <input class="form-control" name="password_confirm" type="password" id="password_confirm" placeholder="Confirm Password" required>
        </div>
        <div class="form-group">
            <label for="agree"><input type="checkbox" id="agree" required> I agree to allow Sinag Araw Energy Solutions Inc. to process my information.</label>
        </div>
        <div class="form-group mb-0 text-center">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </div>
    </form>

    <div class="row justify-content-center">
        <hr style="width: 90%; margin: auto; border-top: 1px solid #b0ada5; margin: 10px;">
        <a href="{{ route('client.login') }}" class="btn btn-success btn-block" type="submit" style="width: 150px; height: 45px;">Login</a>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <p class="text-center">v{{ env('APP_VERSION') }}</p>
        </div>
    </div>
</div>
