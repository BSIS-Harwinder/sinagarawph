@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Forgot Password'
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

                            <div class="card-body p-4">
                                @include('components.forms.forgot')
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                Back to <a href="{{ preg_match("/\badmin\b/i", request()->fullUrl()) ? route('login') : route('client.login') }}">Login</a>
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
