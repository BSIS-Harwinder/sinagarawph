@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Engineer Dashboard'
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
                                <h4 class="page-title">Solar Management System Engineer Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xl-4">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="bi bi-person-lines-fill  font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['user']->schedule->count() }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Clients</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-4">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="bi bi-calendar-week font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['user']->schedule->count() }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">My Schedule</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-4">
                            <a href="#edit-profile" data-toggle="modal">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                                <i class="fas fa-user-tag font-22 avatar-title text-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark mt-1"></h3>
                                                <p class="text-muted mb-1 text-truncate">My Profile</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Clients</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="clients_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Mobile Number</th>
                                            <th>Goal</th>
                                            <th>Alignment</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['user']->schedule as $schedule)
                                                <tr>
                                                    <td>{{ $schedule->client->first_name }} {{ $schedule->client->last_name }}</td>
                                                    <td>{{ $schedule->client->email }}</td>
                                                    <td>{{ $schedule->client->address }}</td>
                                                    <td>{{ $schedule->client->mobile_number }}</td>
                                                    <td class="text-uppercase">{{ $schedule->client->goal }}</td>
                                                    <td>{{ $schedule->client_alignment }}</td>
                                                    <td>
                                                        <a href="{{ route('clients.show', $schedule->client->id) }}" class="btn btn-xs btn-primary">
                                                            <i class="fas fa-eye"></i>  View Client
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('components.footer')

            <div id="edit-profile" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">My Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="profile_form" action="{{ route('engineers.update', $data['user']->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John" value="{{ $data['user']->first_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe" value="{{ $data['user']->last_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ $data['user']->email }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
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
            $('#clients_table').DataTable();
        });
    </script>
@endsection
