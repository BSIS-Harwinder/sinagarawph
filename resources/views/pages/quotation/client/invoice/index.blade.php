@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'My Site Visits'
    ])
@endsection

@php
    $is_client = Auth::guard('client')->check();
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
            'is_client' => $is_client
        ])

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('components.alerts.success')
                    @include('components.alerts.error')
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">

                                    </ol>
                                </div>
                                <h4 class="page-title">Dashboard > My Site Visits</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="orders_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Engineer</th>
                                            <th>Monthly Savings</th>
                                            <th>Annual Savings</th>
                                            <th>Estimated Cost (EC)</th>
                                            <th>EC w/ Net Metering</th>
                                            <th>Payback Period</th>
                                            <th>Scheduled Visit</th>
                                            <th>Visit Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['orders'] as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->employee_name }}</td>
                                                <td>₱ {{ number_format($order->sale->monthly_savings, 2) }}</td>
                                                <td>₱ {{ number_format($order->sale->annual_savings, 2) }}</td>
                                                <td>₱ {{ number_format($order->sale->estimated_cost, 2) }}</td>
                                                <td>₱ {{ number_format($order->sale->estimated_cost_with_net_metering, 2) }}</td>
                                                <td>{{ $order->sale->payback_period }} yrs.</td>
                                                <th>{{ date('F d, Y', strtotime($order->visit_date)) }}</th>
                                                <th>{{ $order->site_visit_status }}</th>
                                                <td>
                                                    @if($order->employee_id != '')
                                                        @if($order->visit_status == 'done')
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    Actions
                                                                </button>

                                                                <div class="dropdown-menu">
                                                                    <a href="{{ route('client.view_order', $order->sale->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-eye"></i>  View Contract
                                                                    </a>
                                                                    <a href="{{ route('client.invoice.tracker', $order->sale->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-chart-bar"></i>  Invoice Tracker
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('client.view_order', $order->sale->id) }}" class="btn btn-xs btn-primary">
                                                            <i class="fas fa-eye"></i>  View Contract
                                                        </a>
                                                    @endif
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
        $('#orders_table').DataTable();
    </script>
@endsection
