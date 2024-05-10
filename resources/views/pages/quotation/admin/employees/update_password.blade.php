@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Update Password'
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
                            <div class="text-center w-75 m-auto">
                                <a href="{{ route('home') }}">
                                    <span><img src="{{ asset('images/sinag.png') }}" alt="" height="120"></span>
                                </a>

                                <p class="text-muted mb-2 mt-3">Please update the temporary password that has been issued with your personal one. </p>
                            </div>

                            <div class="card-body p-4">
                                @include('components.forms.update_password')
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
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
