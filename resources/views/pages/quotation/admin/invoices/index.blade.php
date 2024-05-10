@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Invoices'
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
                                <h4 class="page-title">Solar Management System > Invoices</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="header-title mb-3">Customer Invoices</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="invoice_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Contract ID</th>
                                            <th>Amount</th>
                                            <th>Full Price</th>
                                            <th>Payment Date</th>
                                            <th>Transaction Type</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['invoices'] as $invoice)
                                                <tr>
                                                    <td>{{ $invoice->id }}</td>
                                                    <td>{{ $invoice->sale_id }}</td>
                                                    <td>{{ $invoice->amount }}</td>
                                                    <td>{{ $invoice->full_price }}</td>
                                                    <td>{{ $invoice->payment_date }}</td>
                                                    <td>{{ $invoice->transaction_type }}</td>
                                                    <td class="text-center">
                                                        <a href="#update-invoice"
                                                           class="btn btn-xs btn-primary"
                                                           data-toggle="modal"
                                                           data-id="{{ $invoice->id }}"
                                                           data-sale-id="{{ $invoice->sale_id }}"
                                                           data-view-invoice-url="{{ route('invoices.show', $invoice->id) }}"
                                                           data-update-url="{{ route('invoices.update', $invoice->id) }}">
                                                            <i class="fas fa-eye"></i>  Edit Invoice
                                                        </a>
                                                        @if($invoice->approval_status == 'pending')
                                                            <button type="button" class="btn btn-xs btn-success"
                                                               id="approve_invoice_button"
                                                               data-sale-id="{{ $invoice->sale_id }}"
                                                               data-amount="{{ $invoice->amount }}"
                                                               data-transaction-type="{{ strtolower($invoice->transaction_type) }}"
                                                               data-update-url="{{ route('invoices.update', $invoice->id) }}">
                                                                <i class="fas fa-check"></i>  Approve Invoice
                                                            </button>
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

        <div id="update-invoice" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="invoice_update_form" action="" method="POST" enctype="multipart/form-data">
                    </form>
                </div>
            </div>
        </div>

        <form id="update-invoice-form" action="" method="POST" hidden>
            @csrf
            @method('PATCH')
            <input type="hidden" name="approval_status" value="approved">
            <input type="hidden" name="amount" id="form_amount">
            <input type="hidden" name="transaction_type" id="form_transaction_type">
            <input type="hidden" name="action_id" value="15">
            <input type="hidden" name="sale_id" id="sale_id">
        </form>
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
            $('#invoice_table').DataTable();

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

            $('button#approve_invoice_button').on('click', function() {
                let sale_id = $(this).data('sale-id');
                let amount = $(this).data('amount');
                let transaction_type = $(this).data('transaction-type');
                let update_url = $(this).data('update-url');
                let update_invoice_form = $('#update-invoice-form');

                $('#sale_id').val(sale_id);
                $('#form_amount').val(amount);
                $('#form_transaction_type').val(transaction_type);

                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure to approve this invoice?',
                    text: 'If approved, this will be reflected in the tracker',
                    showConfirmButton: true,
                    showCloseButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Approve',
                    denyButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        update_invoice_form.attr('action', update_url);

                        update_invoice_form.submit();
                    }
                });
            })
        });
    </script>
@endsection
