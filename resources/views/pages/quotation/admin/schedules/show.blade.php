@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'View Client &mdash;' . $data['client']->first_name . ' ' . $data['client']->last_name
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
                                <h4 class="page-title">Solar Management System Dashboard > View Client {{ $data['client']->first_name }} {{ $data['client']->last_name }}</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <form id="client_form" action="{{ route('schedules.update', $data['schedule']->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="employee_id" id="employee_id">
                                <input type="hidden" name="reason_id" id="reason_id">
                                <input type="hidden" name="visit_status" id="visit_status">
                                <div class="card-box">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fa fa-arrow-left"></i> Back
                                                </a>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="text-right">
                                                    @if($data['client']->alignment == "for_approval")
                                                        <a href="#" id="decision-button" data-type="approve" class="btn btn-info">
                                                            Schedule Actions
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="mb-3">Client's Information</h2>

                                    <hr />

                                    <h3 class="mb-3">Quotation</h3>
                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <div class="mb-3 text-right">
                                                    <div class="fw-bold">
                                                        Date Joined: <p class="lead">{{ date('F d, Y', strtotime($data['client']->date_joined)) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="alignment" class="form-label">Alignment</label>
                                                <input type="text" class="form-control text-uppercase" id="alignment" value="{{ $data['client']->alignment }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="average_bill" class="form-label">Average Bill</label>
                                                <input type="text" class="form-control" id="average_bill" value="{{ $data['client']->average_bill }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="goal" class="form-label">Goal</label>
                                                <input type="text" class="form-control text-uppercase" id="goal" value="{{ $data['client']->goal }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="user_status" class="form-label">Status</label>
                                                <input type="text" class="form-control text-uppercase" id="user_status" value="{{ $data['client']->status }}">
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <h3 class="mb-3">Personal</h3>
                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Juan" value="{{ $data['client']->first_name }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Dela Cruz" value="{{ $data['client']->last_name }}" autocomplete="disabled">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" readonly id="email" name="email" placeholder="juandelacruz@gmail.com" value="{{ $data['client']->email }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="09123456789" value="{{ $data['client']->mobile_number }}" autocomplete="disabled">
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <h3 class="mb-3">Address</h3>
                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="street" class="form-label">Street</label>
                                                <input type="text" class="form-control" id="street" name="street" placeholder="House No., Street / Block" value="{{ $data['client']->street }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="barangay" class="form-label">Barangay</label>
                                                <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay / Subdivision" value="{{ $data['client']->barangay }}" autocomplete="disabled">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" class="form-control" id="city" name="city" placeholder="Quezon City" value="{{ $data['client']->city }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="province" class="form-label">Province</label>
                                                <input type="text" class="form-control" id="province" name="province" placeholder="National Capital Region" value="{{ $data['client']->province }}" autocomplete="disabled">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="zip" class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" id="zip" name="zip" placeholder="1008" value="{{ $data['client']->zip }}" autocomplete="disabled">
                                            </div>
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
            $('input[type="text"]').attr('disabled', 'disabled');

            $('#decision-button').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure to approve the schedule?',
                    icon: 'info',
                    focusConfirm: false,
                    showCloseButton: true,
                    showConfirmButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Approve',
                    denyButtonText: 'Reject'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#visit_status').attr('value', 'approve');

                        show_engineer_dropdown();
                    }

                    if (result.isDenied) {
                        $('#visit_status').attr('value', 'reject');

                        show_rejection_reason_dropdown();
                        // $('#client_form').submit();
                    }
                });
            });

            function show_rejection_reason_dropdown() {
                $.ajax({
                    url: '{{ route('reasons.index') }}',
                    type: 'GET',
                    success: function (data) {
                        let options = {};

                        data.forEach((item) => {
                            // options += '<option value="'+item.id+'">'+item.first_name+" "+item.last_name+'</option>';
                            options[item.id] = item.code;
                        });

                        Swal.fire({
                            icon: 'info',
                            title: 'Select a reason',
                            input: 'select',
                            inputOptions: options,
                            confirmButtonText: 'Select',
                            showCloseButton: true,
                            preConfirm: function (selectedValue) {
                                if (!selectedValue) {
                                    Swal.showValidationMessage('Please select a reason for rejection');
                                } else {
                                    $('#reason_id').attr('value', selectedValue);
                                }

                                $('#client_form').submit();
                            }
                        });
                    }
                })
            }

            function show_engineer_dropdown() {
                $.ajax({
                    url: '{{ route('engineers.index') }}',
                    type: 'GET',
                    success: function (data) {
                        let options = {};

                        data.forEach((item) => {
                            // options += '<option value="'+item.id+'">'+item.first_name+" "+item.last_name+'</option>';
                            options[item.id] = item.first_name + ' ' + item.last_name;
                        });

                        Swal.fire({
                            icon: 'info',
                            title: 'Select an engineer',
                            input: 'select',
                            inputOptions: options,
                            confirmButtonText: 'Select',
                            showCloseButton: true,
                            preConfirm: function (selectedValue) {
                                if (!selectedValue) {
                                    Swal.showValidationMessage('Please select an engineer');
                                } else {
                                    $('#employee_id').attr('value', selectedValue);
                                }

                                $('#client_form').submit();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: ", error);

                        Swal.fire({
                            icon: 'error',
                            title: 'There was an error with the request',
                            text: error
                        });
                    }
                });
            }
        });
    </script>
@endsection
