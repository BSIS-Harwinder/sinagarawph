@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Client Contracts'
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
                                <h4 class="page-title">Solar Management System > Contracts</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="header-title mb-3">Contracts</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="contracts_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Client Name</th>
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
                                        @foreach($data['schedules'] as $schedule)
                                            <tr>
                                                <td>{{ $schedule->id }}</td>
                                                <td>{{ $schedule->client_name }}</td>
                                                <td>{{ $schedule->employee_name }}</td>
                                                <td>₱ {{ number_format($schedule->sale->monthly_savings, 2) }}</td>
                                                <td>₱ {{ number_format($schedule->sale->annual_savings, 2) }}</td>
                                                <td>₱ {{ number_format($schedule->sale->estimated_cost, 2) }}</td>
                                                <td>₱ {{ number_format($schedule->sale->estimated_cost_with_net_metering, 2) }}</td>
                                                <td>{{ $schedule->sale->payback_period }} yrs.</td>
                                                <th>{{ date('F d, Y', strtotime($schedule->visit_date)) }}</th>
                                                <th>{{ $schedule->site_visit_status }}</th>
                                                <td class="text-center">
                                                    @if($schedule->employee_id != '')
                                                        @if($schedule->visit_status == 'done')
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    Actions
                                                                </button>

                                                                <div class="dropdown-menu">
                                                                    <a href="{{ route('contracts.view', $schedule->sale->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-eye"></i>  View Contract
                                                                    </a>
                                                                    <a href="#new-invoice" data-id="{{ $schedule->sale->id }}" data-toggle="modal" class="dropdown-item">
                                                                        <i class="fas fa-plus"></i>  Add Invoice
                                                                    </a>
                                                                    <a href="{{ route('invoices.tracker', $schedule->sale->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-chart-bar"></i>  Invoice Tracker
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('contracts.view', $schedule->sale->id) }}" class="btn btn-xs btn-primary">
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
                @include('components.footer')
            </div>
        </div>

        <div id="new-invoice" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="invoice_form" action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="sale_id" id="sale_id">
                        {{-- 16 means encoding invoice --}}
                        <input type="hidden" name="action_id" value="16">

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" min="0" class="form-control" id="amount" name="amount" placeholder="100000">
                            </div>
                            <div class="form-group">
                                <label for="transaction_type">Transaction Type</label>
                                <select id="transaction_type" name="transaction_type" class="custom-select">
                                    <option value>Select Transaction Type</option>
                                    <option value="cash">Cash Payment</option>
                                    <option value="online">Online Payment</option>
                                </select>
                            </div>
                            <div class="custom-file my-3">
                                <input type="file" class="custom-file-input" name="image" id="proof_of_payment" required>
                                <label class="custom-file-label" for="proof_of_payment">Choose file...</label>
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
    <script src="{{ asset('js/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- dashboard 1 init js-->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#contracts_table').DataTable();

            $('a[data-id]').on('click', function() {
                let sale_id = $(this).data('id');

                $('#sale_id').val(sale_id);
            });
        });
    </script>
@endsection
