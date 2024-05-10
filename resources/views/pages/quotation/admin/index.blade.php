@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Admin Dashboard'
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
                                <h4 class="page-title">Solar Management System Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="bi bi-hourglass-split font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['pending_clients']->count() }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Unverified Clients</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="bi bi-person-vcard-fill font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['employees']->count() }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Employees</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Employees</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="employees_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['employees'] as $employee)
                                                <tr>
                                                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                                    <td>{{ $employee->email }}</td>
                                                    <td>{{ $employee->role->name }}</td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" class="btn btn-xs btn-primary">
                                                            <i class="mdi mdi-eye"></i> View
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="bi bi-person-lines-fill font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['clients']->count() }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Clients</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="bi bi-person-lines-fill font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $data['site_visits_count'] }}</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Site Visits</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card-box">
                                        <h4 class="header-title mb-3">Clients</h4>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-hover table-centered m-0" id="clients_table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Mobile Phone</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['clients'] as $client)
                                                        <tr>
                                                            <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                                                            <td>{{ $client->address }}</td>
                                                            <td>{{ $client->mobile_number }}</td>
                                                            <td>{{ $client->visit_status }}</td>
                                                            <td>
                                                                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-xs btn-success">
                                                                    <i class="mdi mdi-eye"></i> View
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
                </div>
                @include('components.footer')
            </div>

            <div class="right-bar">
                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-right">
                        <i class="dripicons-cross noti-icon"></i>
                    </a>
                    <h5 class="m-0 text-white">Settings</h5>
                </div>
                <div class="slimscroll-menu">
                    <!-- User box -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="{{ asset('images/users/default.png') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                            <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                        </div>

                        <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
                        <p class="text-muted mb-0"><small>Admin Head</small></p>
                    </div>

                    <!-- Settings -->
                    <hr class="mt-0" />
                    <h5 class="pl-3">Basic Settings</h5>
                    <hr class="mb-0" />

                    <div class="p-3">
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="Rcheckbox1" type="checkbox" checked>
                            <label for="Rcheckbox1">
                                Notifications
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="Rcheckbox2" type="checkbox" checked>
                            <label for="Rcheckbox2">
                                API Access
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="Rcheckbox3" type="checkbox">
                            <label for="Rcheckbox3">
                                Auto Updates
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="Rcheckbox4" type="checkbox" checked>
                            <label for="Rcheckbox4">
                                Online Status
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-0">
                            <input id="Rcheckbox5" type="checkbox" checked>
                            <label for="Rcheckbox5">
                                Auto Payout
                            </label>
                        </div>
                    </div>
                </div>

                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ asset('images/users/default.png') }}" class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                    <p class="inbox-item-text">Hey! there I'm available...</p>
                </div>
                <div class="inbox-item">
                    <div class="inbox-item-img"><img src="{{ asset('images/users/default.png') }}" class="rounded-circle" alt=""></div>
                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                    <p class="inbox-item-text">This theme is awesome!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
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
            $('#employees_table').DataTable();
            $('#clients_table').DataTable();
        });
    </script>
@endsection
