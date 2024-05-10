<div class="text-center w-75 m-auto">
    <a href="{{ route('login') }}">
        <span><img src="{{ asset('images/sinag.png') }}" alt="" height="120"></span>
    </a>
    <p class="text-muted mb-4 mt-3">Please identify yourself first, and we'll check our database.</p>
</div>

<form action="{{ route('client.send_password_link') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input class="form-control" name="email" type="email" id="email" required="" placeholder="Enter your email address">
    </div>
    <div class="form-group mb-0 text-center">
        <button class="btn btn-success btn-block" name="confirm" type="submit"> Confirm </button>
    </div>
</form>
