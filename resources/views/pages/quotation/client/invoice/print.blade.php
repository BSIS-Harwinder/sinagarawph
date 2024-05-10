@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Client Contract #' . $data['sale']->id
    ])
@endsection

@php
    $is_client = Auth::guard('client')->check();
@endphp

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('libs/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/footable/footable.core.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @media print {
            .hidden-for-printing {
                display: none;
            }
        }
    </style>
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
                    <div class="row my-2 hidden-for-printing">
                        <div class="col-12">
                            <a href="{{ route('client.invoice.tracker', $data['sale']->id) }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left">  Back</i>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">

                                    </ol>
                                </div>
                                <h4 class="page-title">Sale ID: {{ $data['sale']->id }}</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row" id="invoice_receipt">
                        <div class="col-12">
                            @include('components.invoice.index', [
                                'sale' => $data['sale']
                            ])
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
        $(document).ready(function() {
            $('#print_button').on('click', function() {
                let content = $('#contract').html();
                let print_window = window.open('', '_blank');
                print_window.document.open();
                print_window.document.write('<html><head><title>invoice-{{ $data['sale']->id }}-{{ date('ymd') }}</title></head><body>');
                print_window.document.write(content);
                print_window.document.write('</body></html>');
                print_window.document.close();
                print_window.print();
            });
        });
    </script>
@endsection
