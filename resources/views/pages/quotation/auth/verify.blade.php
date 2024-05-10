@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Update Password'
    ])
@endsection

@section('styles')
    @include('components.alerts.success')
    @include('components.alerts.error')

    <div class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">
                            <div class="card-body p-4">
                                @include('components.forms.verify')
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <a href="{{ route('client.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                                <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
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

@section('content')

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/app.min.js') }}"></script>
@endsection
