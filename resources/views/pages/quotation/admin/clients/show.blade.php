@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Clients'
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
                                <h4 class="page-title">Solar Management System > View Client {{ $data['client']->first_name }} {{ $data['client']->last_name }}</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            @if(count($data['client']->schedule) > 0)
                                                @if($data['client']->schedule->last()->visit_status == 'done')
                                                    <a href="javascript:void(0)" class="btn btn-outline-primary text-uppercase">
                                                        Site Visit: {{ $data['client']->schedule->last()->visit_status }}
                                                    </a>
                                                @elseif($data['client']->schedule->last()->visit_status == 'for_approval')
                                                    <a href="javascript:void(0)" class="btn btn-outline-info text-uppercase">
                                                        Site Visit: {{ $data['client']->schedule->last()->visit_status }}
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="btn btn-outline-warning text-uppercase">
                                                        Site Visit: {{ $data['client']->schedule->last()->visit_status }}
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-outline-primary text-uppercase">
                                                    Client has not scheduled a visit.
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#client_information" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            <h2 class="mb-3">Client's Information</h2>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#electric_bill" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <h2 class="mb-3">Electricity Bill</h2>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#visit_confirmation" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <h2 class="mb-3">Site Visit</h2>
                                        </a>
                                    </li>
                                </ul>

                                <hr />

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="client_information">
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

                                        <hr />

                                        @if(count($data['client']->schedule) > 0)
                                            @if($data['client']->schedule->last()->visit_status == 'done')
                                                <h3 class="mb-3">Site Visit Remarks</h3>
                                                <div class="mb-3">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="visit_remarks">Remarks: </label>
                                                                <textarea id="visit_remarks" name="remarks" rows="2" cols="40" class="form-control">{!! $data['client']->schedule->last()->remarks !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="tab-pane" id="electric_bill">
                                        @if(Auth::user()->role->level == 1)
                                            @if (!empty($data['client']->bill))
                                                <div class="mb-3">
                                                    <h3 id="mb-3">Electricity Bill</h3>

                                                    <div class="mb-3">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-6">
                                                                <form id="bill_form" action="{{ route('clients.update', $data['client']->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')

                                                                    <input type="hidden" name="bill_status">

                                                                    <div class="form-group">
                                                                        <label for="bill_status">Bill Status: </label>
                                                                        <select id="bill_status" name="bill_status" class="custom-select">
                                                                            <option value="approved">Approve</option>
                                                                            <option value="rejected">Reject</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        <hr />

                                        <div class="container-fluid">
                                            @if(empty($data['client']->bill))
                                                <div class="text-center">
                                                    <div class="h3">Client has not submitted any bills.</div>
                                                </div>
                                            @else
                                                <img src="{{ asset('images/bills/' . $data['client']->bill) }}" style="max-width: 100%; height: auto; display: block; margin: auto;" alt="profile-pic">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="visit_confirmation">
                                        <hr />

                                        <div class="container-fluid">
                                            @if(empty($data['client']->schedule->last()->confirmation_image) || $data['client']->schedule->last()->visit_status != 'done')
                                                <div class="text-center">
                                                    <div class="h3">Site visit has not been made.</div>
                                                </div>
                                            @else
                                                <img src="{{ asset('images/site_visits/' . $data['client']->schedule->last()->confirmation_image) }}" style="max-width: 100%; height: auto; display: block; margin: auto;" alt="profile-pic">
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
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
    <script src="{{ asset('js/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- dashboard 1 init js-->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="text"], textarea').attr('disabled', 'disabled');
        });
    </script>
@endsection
