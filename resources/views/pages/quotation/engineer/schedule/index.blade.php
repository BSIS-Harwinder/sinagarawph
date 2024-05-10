@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Schedules'
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
                                <h4 class="page-title">Solar Management System Engineer Dashboard > Schedules</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                @include('components.forms.date-selector')
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="schedule_container" class="container-fluid">
                                <div class="card-box">
                                    <div class="my-4 text-center">
                                        <div class="h4 lead">Please select a date to see scheduled site visits.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('components.footer')
        </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/swal.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- Dashboard 1 init js-->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#schedule-form').on('submit', function(e) {
                e.preventDefault();
                let from = $('#from').val();
                let to = $('#to').val();

                $.ajax({
                    url: `{{ route('view.engineer.schedule') }}?from=${from}&to=${to}`,
                    type: 'GET',
                    dataType: 'HTML',
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: () => {
                        Alert.fire({
                            icon: 'info',
                            title: 'Please wait while we query the results.',
                        });
                    },
                    success: (result) => {
                        console.log(result);

                        Alert.fire({
                            icon: 'success',
                            title: 'Schedule has been loaded.'
                        });

                        $('#schedule_container').empty().append(result);
                    },
                    error: (xhr, status, errorThrown) => {
                        if (xhr.responseJSON) {
                            let errors = "";

                            if (Array.isArray(xhr.responseJSON)) {
                                for (let i = 0; i <= xhr.responseJSON.length; i++) {
                                    errors = '<p>' + xhr.responseJSON[i].message + '</p>';
                                }
                            } else if (xhr.responseJSON.message) {
                                errors = '<p>' + xhr.responseJSON.message + '</p>';
                            } else {
                                errors = '<p>' + xhr.responseJSON.error + '</p>';
                            }

                            Alert.fire({
                                icon: 'error',
                                title: 'Error/s had been encountered while processing your request',
                                html: '' +
                                    '' + errors + '',
                            });
                        } else {
                            if (xhr.responseText.includes('SQLSTATE[23000]')) {
                                errors = '<p>A field has been <span class="badge badge-danger">Undefined</span></p>';

                                Alert.fire({
                                    icon: 'error',
                                    title: 'Error/s had been encountered while processing your request',
                                    html: '' +
                                        '' + errors + '',
                                });
                            } else {
                                Alert.fire({
                                    icon: 'error',
                                    title: xhr.status + ' ' + xhr.statusText,
                                });
                            }
                        }
                    }
                })
            })
        });
    </script>
@endsection
