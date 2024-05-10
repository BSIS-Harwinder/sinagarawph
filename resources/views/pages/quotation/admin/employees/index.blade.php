@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Employees'
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
                                <h4 class="page-title">Solar Management System > Employees</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="#new-user" data-toggle="modal" class="btn btn-outline-dark">
                                                <i class="fas fa-plus"></i> New Employee
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="header-title mb-3">Employees</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0" id="employees_table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['employees'] as $engineer)
                                            <tr>
                                                <td>{{ $engineer->id }}</td>
                                                <td>{{ $engineer->first_name }}</td>
                                                <td>{{ $engineer->last_name }}</td>
                                                <td>{{ $engineer->email }}</td>
                                                <td>{{ $engineer->role->name }}</td>
                                                <td class="text-center">
                                                    <a id="reset_password_button" href="#" data-employee-id="{{ $engineer->id }}" class="btn btn-xs btn-info btn-block">
                                                        <i class="mdi mdi-lock"></i> Change Password
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

        <div id="new-user" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="profile_form" action="{{ route('engineers.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role_id" value="2">

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John" value="{{ old('first_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe" value="{{ old('last_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
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

        <form id="reset_password_form" action="{{ route('engineers.send_temporary_password') }}" method="POST" hidden>
            @csrf
            <input type="hidden" id="employee_id" name="employee_id">
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
            $('#employees_table').DataTable();

            $('a#reset_password_button').on('click', function(e) {
                e.preventDefault();

                let employee_id = $(this).attr('data-employee-id');

                Swal.fire({
                    icon: 'info',
                    title: 'Are you sure to reset this user\'s password?',
                    showCloseButton: true,
                    showConfirmButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Confirm',
                    denyButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set the employee id's password.
                        $('#employee_id').val(employee_id);
                        $('#reset_password_form').submit();
                    }
                });
            })
        });
    </script>
@endsection
