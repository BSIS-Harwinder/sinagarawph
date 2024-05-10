@if(count($data['schedules']) > 0)
    @foreach($data['schedules'] as $schedule)
        <div class="card-box">
            <div class="row my-2">
                <div class="col-md-12">
                    <div class="h3">Client Information</div>
                    <hr class="fw-bolder">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="mb-3">Personal</h3>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Juan" value="{{ $schedule->client->first_name }}" autocomplete="disabled">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Dela Cruz" value="{{ $schedule->client->last_name }}" autocomplete="disabled">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" readonly id="email" name="email" placeholder="juandelacruz@gmail.com" value="{{ $schedule->client->email }}" autocomplete="disabled">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile_number" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="09123456789" value="{{ $schedule->client->mobile_number }}" autocomplete="disabled">
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <h3 class="mb-3">Address</h3>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="street" class="form-label">Street</label>
                                        <input type="text" class="form-control" id="street" name="street" placeholder="House No., Street / Block" value="{{ $schedule->client->street }}" autocomplete="disabled">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="barangay" class="form-label">Barangay</label>
                                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay / Subdivision" value="{{ $schedule->client->barangay }}" autocomplete="disabled">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Quezon City" value="{{ $schedule->client->city }}" autocomplete="disabled">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="province" class="form-label">Province</label>
                                        <input type="text" class="form-control" id="province" name="province" placeholder="National Capital Region" value="{{ $schedule->client->province }}" autocomplete="disabled">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="zip" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="1008" value="{{ $schedule->client->zip }}" autocomplete="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="mb-3">Quotation</h3>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="mb-3 text-right">
                                            <div class="fw-bold">
                                                Date Joined: <p class="lead">{{ date('F d, Y', strtotime($schedule->client->date_joined)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="alignment" class="form-label">Alignment</label>
                                        <input type="text" class="form-control text-uppercase" id="alignment" value="{{ $schedule->client->alignment }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="average_bill" class="form-label">Average Bill</label>
                                        <input type="text" class="form-control" id="average_bill" value="{{ $schedule->client->average_bill }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="goal" class="form-label">Goal</label>
                                        <input type="text" class="form-control text-uppercase" id="goal" value="{{ $schedule->client->goal }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="user_status" class="form-label">Status</label>
                                        <input type="text" class="form-control text-uppercase" id="user_status" value="{{ $schedule->client->status }}">
                                    </div>
                                </div>
                            </div>

                            <h3 class="mb-3">Visitation Remarks</h3>
                            <form id="remarks_form" action="{{ route('schedules.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="visit_status">Visit Status: </label>
                                    <select id="visit_status" name="visit_status" class="custom-select">
                                        <option value>-- Visit Status --</option>
                                        <option value="done">Done</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="visit_remarks">Remarks: </label>
                                    <textarea id="visit_remarks" name="remarks" rows="2" cols="40" class="form-control"></textarea>
                                </div>

                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="confirmation_image" name="image">
                                    <label class="custom-file-label" for="confirmation_image">Choose file</label>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-6 text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="row">
        <div class="col-md-12">
            <div id="schedule_container" class="container-fluid">
                <div class="card-box">
                    <div class="my-4 text-center">
                        <div class="h4 lead">No scheduled visits today.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
