<div class="text-center w-75 m-auto">
    <a href="{{ route('login') }}">
        <img src="{{ asset('images/sinag.png') }}" alt="" height="120">
    </a>
</div>

<p class="text-muted mb-4 mt-3" style="font-size: 14px; color: #777; margin-bottom: 0px; margin-top: 1px;">
    Welcome to Sinag Araw Energy Solutions Inc! <br><br> Before you can start enjoying our services, we need you to verify your email address.
</p>

<div class="form-group mb-3">
    {{ __('Before proceeding, please check your email for a verification link.') }}
    {{ __('If you did not receive the email') }},
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
    </form>
</div>
