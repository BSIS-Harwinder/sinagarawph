@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Client Schedule'
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
                                <h4 class="page-title">Solar Management System Dashboard > Schedules</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Client Schedules</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="schedules_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Assigned Engineer</th>
                                            <th>Schedule</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['schedules'] as $schedule)
                                            <tr>
                                                <td>{{ $schedule->client->id }}</td>
                                                <td>{{ $schedule->client->first_name }}</td>
                                                <td>{{ $schedule->client->last_name }}</td>
                                                <td>{{ $schedule->client->email }}</td>
                                                <td>{{ $schedule->employee_name }}</td>
                                                <td>{{ $schedule->visit_date }}</td>
                                                <td>{{ $schedule->visit_status }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-xs btn-info">
                                                        <i class="mdi mdi-eye"></i> View Client
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
            $('#schedules_table').DataTable();
        });
    </script>
@endsection
