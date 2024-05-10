@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Invoice Tracker'
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
                                <h4 class="page-title">Solar Management System > Invoice Tracker</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-box">
                                <p class="lead">Remaining Balance</p>
                                <div class="h4">₱ {{ number_format($data['sale']->remaining_balance) }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box">
                                <p class="lead">Full Price</p>
                                <div class="h4">₱ {{ number_format($data['sale']->full_price) }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box">
                                <p class="lead">Status</p>
                                <div class="h4 {{ $data['sale']->payment_status != 'Paid' ? 'text-danger' : 'text-success' }}">{{ $data['sale']->payment_status }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <h4 class="header-title mb-3">Invoice Tracker</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            @if($data['sale']->payment_status != 'Paid')
                                                <div class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="bottom" title="Printing will be available upon full payment">
                                                    <a href="{{ route('client.invoice.print', $data['sale']->id) }}" class="btn btn-primary disabled">
                                                        <i class="fas fa-print"></i>  Print Invoice
                                                    </a>
                                                </div>
                                            @else
                                                <a href="{{ route('client.invoice.print', $data['sale']->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-print"></i>  Print Invoice
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="invoice_tracker_table"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('components.footer')
            </div>
        </div>

        <div id="update-invoice" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="invoice_update_form" action="" method="POST">
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
            $('#invoice_tracker_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('client.invoice.tracker.datatable', $data['sale']->id) }}',
                    data: (d) => {

                    }
                },
                columns: [
                    {
                        data: 'id',
                        title: 'Id',
                        name: 'id'
                    },
                    {
                        data: 'sale_id',
                        title: 'Sale Id',
                        name: 'sale_id'
                    },
                    {
                        data: 'amount',
                        title: 'Amount',
                        name: 'amount'
                    },
                    {
                        data: 'full_price',
                        title: 'Full Price',
                        name: 'full_price',
                        visible: false
                    },
                    {
                        data: 'payment_date',
                        title: 'Payment Date',
                        name: 'payment_date'
                    },
                    {
                        data: 'transaction_type',
                        title: 'Transaction Type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'proof_of_payment',
                        title: 'Proof of Payment',
                        name: 'proof_of_payment',
                        visible: false
                    },
                    {
                        data: 'approval_status',
                        title: 'Admin Approval Status',
                        name: 'approval_status',
                        visible: false
                    },
                    {
                        data: 'actions',
                        title: 'Actions',
                        name: 'actions',
                        render: function (data, action, row) {
                            return '' +
                                '<a href="/images/proof_of_payments/'+ row.proof_of_payment +'" class="btn btn-xs btn-primary" target="_blank">' +
                                '   <i class="fas fa-eye"></i>  View Proof of Transaction' +
                                '</a>';
                        }
                    }
                ],
                order: [0, 'desc']
            });

            $('a[data-update-url]').on('click', function() {
                let action_url = $(this).data('update-url');
                let view_invoice_url = $(this).data('view-invoice-url');

                $('#invoice_update_form').attr('action', action_url);

                $.ajax({
                    type: 'GET',
                    url: view_invoice_url,
                    dataType: 'html',
                    processData: false,
                    contentType: false,
                    success: (result) => {
                        $('#invoice_update_form').empty().append(result);
                    },
                    error: (xhr) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'There were errors processing your request',
                            text: xhr
                        });

                        console.log("Error Occurred in invoice/index.blade: ", xhr);
                    }
                })
            });
        });
    </script>
@endsection
