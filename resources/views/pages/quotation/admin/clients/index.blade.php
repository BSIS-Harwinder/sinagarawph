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
                                <h4 class="page-title">Solar Management System > Clients</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Clients</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="clients_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Alignment</th>
                                            <th>Goal</th>
                                            <th>Bill</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['clients'] as $client)
                                            <tr>
                                                <td>{{ $client->id }}</td>
                                                <td>{{ $client->first_name }}</td>
                                                <td>{{ $client->last_name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td class="text-uppercase">{{ $client->alignment }}</td>
                                                <td class="text-uppercase">{{ $client->goal }}</td>
                                                <td>{{ $client->has_image == 1 ? 'PRESENT' : 'NOT PRESENT' }}</td>
                                                <td class="text-uppercase">{{ $client->status }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-xs btn-info">
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
    <script src="{{ asset('js/libs/flatpickr/flatpickr.min.js') }}"></script>
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
