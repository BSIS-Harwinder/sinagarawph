@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Login'
    ])
@endsection

@section('styles')

@endsection

@section('content')
    @include('components.alerts.success')
    @include('components.alerts.error')

    <div class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">
                            @include('components.forms.login')
                        </div>
                        <div class="row mt-3">
                            @if(Route::currentRouteName() == 'client.login')
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ route('login') }}">Admin Login</a>
                                </div>
                            @else
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ route('client.login') }}">Client Login</a>
                                </div>
                            @endif
                            <div class="col-12 text-center">
                                Back to <a href="{{ route('home') }}">Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/app.min.js') }}"></script>
@endsection
