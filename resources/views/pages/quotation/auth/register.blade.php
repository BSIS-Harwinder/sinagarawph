@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Signup'
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
                            @include('components.forms.register')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/app.min.js') }}"></script>
@endsection
