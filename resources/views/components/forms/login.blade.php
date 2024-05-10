<div class="card-body p-4">
    @if(Route::currentRouteName() == 'client.login')
        <div class="text-center w-75 m-auto">
            <a href="{{ route('home') }}">
                <span><img src="{{ asset('images/sinag.png') }}" alt="" height="120"></span>
            </a>

            <p class="text-muted mb-4 mt-3">Enter your email and password to access client panel.</p>
        </div>

        <form method="POST" action="{{ route('client.login') }}">
            {{ csrf_field() }}
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input class="form-control" name="email" type="email" id="email" required placeholder="Email Address">
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input class="form-control" name="password" type="password" required id="password"
                       placeholder="Enter Password">
                <p style="margin-top: 5px;">forget password? <a href="{{ route('client.password.reset') }}"><b>Recover
                            Account</b></a></p>
            </div>

            <div class="form-group mb-0 text-center">
                <button class="btn btn-success" type="submit">Login</button>
            </div>
        </form>

        <div class="row justify-content-center">
            <hr style="width: 90%; margin: auto; border-top: 1px solid #b0ada5; margin: 10px;">
            <a href="{{ route('register') }}" class="btn btn-primary btn-block" type="submit"
               style="width: 150px; height: 45px;">Sign Up</a>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <p class="text-center">v{{ env('APP_VERSION') }}</p>
            </div>
        </div>
    @else
        <div class="text-center w-75 m-auto">
            <a href="{{ route('home') }}">
                <span><img src="{{ asset('images/sinag.png') }}" alt="" height="120"></span>
            </a>

            <p class="text-muted mb-4 mt-3">Enter your email and password to access admin panel.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input class="form-control" name="email" type="email" id="email" required placeholder="Email Address">
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input class="form-control" name="password" type="password" required id="password"
                       placeholder="Enter Password">
            </div>

            <div class="form-group mb-0 text-center">
                <button class="btn btn-success" type="submit">Login</button>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <p class="text-center">v{{ env('APP_VERSION') }}</p>
                </div>
            </div>
        </form>
    @endif
</div>
