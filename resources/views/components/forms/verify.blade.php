<div class="card-body p-4">
    <div class="text-center w-75 m-auto">
        <a href="{{ route('login') }}">
            <img src="{{ asset('images/sinag.png') }}" alt="" height="120">
        </a>
    </div>

    <form method="POST" action="{{ route('client.reset_password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <p class="text-muted mb-4 mt-3" style="font-size: 14px; color: #777; margin-bottom: 0px; margin-top: 1px;">Recover your password</p>

        <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email address" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required autocomplete="password" autofocus>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmation Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required autocomplete="password_confirm" autofocus>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success btn-block">Change Password</button>
            </div>
        </div>
    </form>
</div>
