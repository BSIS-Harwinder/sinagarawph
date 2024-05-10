@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'View Offer'
    ])
@endsection

@php
    $is_client = Auth::guard('client')->check();
    $user_level = Auth::user()->role->level
@endphp

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('libs/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/footable/footable.core.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div id="wrapper">
        @include('components.dashboard.nav')
        @include('components.dashboard.sidebar', [
            'is_client' => $is_client,
            'user_level' => $user_level
        ])

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('components.alerts.success')
                    @include('components.alerts.error')
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Solar Management System > View Offer</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div hidden>
                                <form id="delete-offer-form" action="{{ route('offers.delete', $data['offer']->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form id="offer_form" action="{{ route('offers.update', $data['offer']->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="employee_id" id="employee_id">
                                <input type="hidden" name="visit_status" id="visit_status">
                                <div class="card-box">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="{{ route('offers.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fa fa-arrow-left"></i> Back
                                                </a>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a href="#" id="delete-offer-button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="mb-3">Offer Information</h2>

                                    <hr />

                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="cost" class="form-label">Cost</label>
                                                <input type="text" class="form-control" id="cost" name="cost" placeholder="20000" value="{{ $data['offer']->cost }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="size" class="form-label">Size</label>
                                                <input type="text" class="form-control" id="size" name="size" placeholder="1.0kwp" value="{{ $data['offer']->size }}" autocomplete="disabled">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="panels" class="form-label">Panels</label>
                                                <input type="text" class="form-control" readonly id="panels" name="panels" placeholder="1-10" value="{{ $data['offer']->panels }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="savings" class="form-label">Savings</label>
                                                <input type="text" class="form-control" id="savings" name="savings" placeholder="1500" value="{{ $data['offer']->savings }}" autocomplete="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-secondary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @include('components.footer')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/swal.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- dashboard 1 init js-->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#delete-offer-button').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Offer',
                    text: 'Are you sure to delete this offer? data may be lost.',
                    showCloseButton: true,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    const { isConfirmed, isDismissed, isCancelled } = result;

                    if (isConfirmed) {
                        $('#delete-offer-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
