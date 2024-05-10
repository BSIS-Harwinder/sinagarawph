@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Offers'
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
                                <h4 class="page-title">Solar Management System > Offers</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="header-title mb-3">Offers</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <a href="#create_new_offer" data-toggle="modal" class="btn btn-outline-secondary">
                                                <i class="fa fa-plus"></i> New Offer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="offers_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Cost</th>
                                                <th>Size</th>
                                                <th>Panels</th>
                                                <th>Savings</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['offers'] as $offer)
                                                <tr>
                                                    <td>{{ $offer->id }}</td>
                                                    <td>{{ $offer->cost }}</td>
                                                    <td>{{ $offer->size }}</td>
                                                    <td>{{ $offer->panels }}</td>
                                                    <td>{{ $offer->savings }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-xs btn-info">
                                                            <i class="mdi mdi-eye"></i> View Offer
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

            <div id="create_new_offer" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Offer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form id="offer_form" action="{{ route('offers.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="mb-3">Offer Information</h4>

                                        <hr />

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="cost" class="form-label">Cost</label>
                                                <input type="text" class="form-control" id="cost" name="cost" placeholder="20000" autocomplete="disabled">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="size" class="form-label">Size</label>
                                                <input type="text" class="form-control" id="size" name="size" placeholder="1.0kwp" autocomplete="disabled">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="panels" class="form-label">Panels</label>
                                                <input type="text" class="form-control" id="panels" name="panels" placeholder="1-10" autocomplete="disabled">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="savings" class="form-label">Savings</label>
                                                <input type="text" class="form-control" id="savings" name="savings" placeholder="1500" autocomplete="disabled">
                                            </div>
                                        </div>
                                    </div>
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
            $('#offers_table').DataTable();
        });
    </script>
@endsection
