@extends('layouts.dashboard')

@section('seo')
    @include('components.meta', [
        'title' => 'Client Dashboard'
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
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="{{ asset('images/users/default.png') }}" class="rounded-circle avatar-lg img-thumbnail"
                                     alt="profile-image">
                                <div class="text-centre mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Client Full Name :</strong> <span class="ml-2">{{ $data['user']->first_name }} {{ $data['user']->last_name }}</span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Client Email :</strong> <span class="ml-2">{{ $data['user']->email }}</span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Client Bill :</strong> <span class="ml-2">{{ $data['user']->average_bill }}</span></p>

                                    <div hidden>
                                        <div class="form-group">
                                            <label for="bill_amount">Bill Amount: </label>
                                            <input type="number" id="bill_amount" class="form-control" value="{{ $data['user']->average_bill }}" required onchange="update_values()">
                                        </div>
                                        <div class="form-group">
                                            <label for="systemPriceDropdown">System Price: </label>
                                            <select id="systemPriceDropdown" name="systemPriceDropdown" class="custom-select" onchange="update_values()">
                                                <option value="half" {{ $data['user']->goal == 'half' ? 'selected' : '' }}>Half</option>
                                                <option value="full" {{ $data['user']->goal == 'full' ? 'selected' : '' }}>Full</option>
                                            </select>
                                        </div>
                                    </div>

                                    <a href="#update_information" data-toggle="modal" class="btn btn-warning btn-block">Update Information</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="table-responsive">
                                            <table id="offers_table" class="table">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>Cost</th>
                                                        <th>Size</th>
                                                        <th>Panels</th>
                                                        <th>Savings</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['panels'] as $panel)
                                                        <tr>
                                                            <td>₱{{ number_format($panel->cost, 2) }}</td>
                                                            <td>{{ $panel->size }}</td>
                                                            <td>{{ $panel->panels }}</td>
                                                            <td>₱{{ number_format($panel->savings, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-xl-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#quotation" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Estimation
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#electric_bill" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            Electricity Bill
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="quotation">
                                        <form method="POST">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th colspan="2">GRID-TIE SOLAR PACKAGE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>System Peak</td>
                                                            <td><span id="systemSize"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Monthly Savings</td>
                                                            <td><span id="monthlySavings"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Annual Savings </td>
                                                            <td><span id="annualSavings"></span></td>
                                                        </tr>
                                                        <tr style="display:none ;">
                                                            <td>System Peak:</td>
                                                            <td><span id="systemPeak"></span></td>
                                                        </tr>
                                                        <tr>
                                                        <tr>
                                                            <td>Estimated Cost </td>
                                                            <td><span id="estimatedCost"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="table-warning">Estimated Cost with Net Metering </td>
                                                            <td class="table-warning"><span id="estimatedCostNetMetering"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payback Period</td>
                                                            <td><span id="paybackPeriod"></span> yrs</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Annual Electricity Bill</td>
                                                            <td><span id="annualElectricityBill"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Annual Bill without Solar</td>
                                                            <td><span id="annualBillWithoutSolar"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table">
                                                    <thead class="table-secondary">
                                                    <tr>
                                                        <th colspan="3">BILL OF MATERIALS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="important">
                                                        <td class="table-warning">Materials</td>
                                                        <td class="table-warning">Description</td>
                                                        <td class="table-warning">Quantity</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Solar Panels</td>
                                                        <td>Canadian Mono 545W</td>
                                                        <td><span id="panelCount"></span></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Power Inverter</td>
                                                        <td>Single Phase Inverter upto 7.8kW input</td>
                                                        <td>1</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Railings and Mountings</td>
                                                        <td>Complete Mounting Set</td>
                                                        <td>2 set Box</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Wires & Protective Devices</td>
                                                        <td>Wires, Breakers, SPD, etc</td>
                                                        <td>1 Lot</td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <table class="table">
                                                    <thead class="table-secondary">
                                                    <tr>
                                                        <th colspan="3">WARRANTY AND PERFORMANCE GUARANTEE</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Solar Panels </td>
                                                        <td>Manufacturer's Warranty</td>
                                                        <td>10yrs</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Power Inverter</td>
                                                        <td>Manufacturer's Warranty</td>
                                                        <td>5yrs</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Full System</td>
                                                        <td>Engineering and Workmanship warranty</td>
                                                        <td>2yrs</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                @if(count($data['user']->schedule) > 0)
                                                    @if($data['user']->schedule->last()->visit_status == 'rejected' || $data['user']->schedule->last()->visit_status == 'done')
                                                        <div class="form-group mb-0 text-center">
                                                            <a href="#set_site_visit" data-toggle="modal" class="btn btn-warning btn-block">Schedule Site Visit</a>
                                                        </div>
                                                    @elseif($data['user']->schedule->last()->visit_status == 'approved')
                                                        <div class="form-group mb-0 text-center">
                                                            <button type="button" class="btn btn-info btn-block">Download preliminary contract</button>
                                                        </div>
                                                    @elseif($data['user']->schedule->last()->visit_status == 'for_approval')
                                                        <div class="form-group mb-0 text-center">
                                                            <button type="button" class="btn btn-info btn-block">Schedule pending for approval</button>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="form-group mb-0 text-center">
                                                        <a href="#set_site_visit" data-toggle="modal" class="btn btn-warning btn-block">Schedule Site Visit</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="electric_bill">
                                        <div class="table-responsive">
                                            @if(empty($data['user']->bill) || $data['user']->bill_status == 'rejected')
                                                <div class="form-group">
                                                    <form action="{{ route('client.update', $data['user']->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="my-2">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="image" id="bill" required>
                                                                <label for="bill" class="custom-file-label">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" name="resubmit" class="ladda-button btn btn-success" data-style="expand-right" style="margin-top: 5px;">Upload Bill</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @else
                                                <img src="{{ asset('images/bills/' . $data['user']->bill) }}" style="max-width: 100%; height: auto; display: block; margin: auto;" alt="profile-pic">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        @include('components.footer')
        <!-- end Footer -->

        <div id="set_site_visit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="set_site_visit"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Set Site Visit
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-content">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-6">
                                <form action="{{ route('client.schedule_visit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="client_id" value="{{ $data['user']->id }}">
                                    <div class="form-group">
                                        <label for="visit_date" class="col-form-label">Schedule Site Visit Date</label>
                                        <input type="datetime-local" name="visit_date" class="form-control" required id="visit_date" placeholder="{{ $data['user']->site_visit }}">
                                    </div>

                                    <button type="submit" class="ladda-button btn btn-success">Schedule</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="update_information" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="update_information"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Update User Information
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-content">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-9">
                                <form action="{{ route('client.update', $data['user']->id) }}" method="POST" autocomplete="off">
                                    @csrf
                                    @method('PATCH')

                                    <div class="h4">Personal Information</div>

                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name" class="col-form-label">First Name: </label>
                                                <input type="text" name="first_name" class="form-control" required id="first_name" placeholder="{{ $data['user']->first_name }}" value="{{ $data['user']->first_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name" class="col-form-label">Last Name: </label>
                                                <input type="text" name="last_name" class="form-control" required id="last_name" placeholder="{{ $data['user']->last_name }}" value="{{ $data['user']->last_name }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile_number" class="col-form-label">Mobile Number: </label>
                                                <input type="text" name="mobile_number" class="form-control" required id="mobile_number" placeholder="{{ $data['user']->mobile_number }}" value="{{ $data['user']->mobile_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="average_bill" class="col-form-label">Average Bill: </label>
                                                        <input type="number" min="500" name="average_bill" class="form-control" required id="average_bill" placeholder="{{ $data['user']->average_bill }}" value="{{ $data['user']->average_bill }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="goal" class="col-form-label">Goal: </label>
                                                        <select name="goal" id="goal" class="custom-select" required>
                                                            @if($data['user']->goal == 'half')
                                                                <option value="half" selected>Half</option>
                                                                <option value="full">Full</option>
                                                            @else
                                                                <option value="half">Half</option>
                                                                <option value="full" selected>Full</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="h4">My Address</div>

                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="street" class="col-form-label">Street </label>
                                                <input type="text" name="street" class="form-control" required id="street" placeholder="{{ $data['user']->street }}" value="{{ $data['user']->street }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="barangay" class="col-form-label">Subdivision / Barangay </label>
                                                <input type="text" name="barangay" class="form-control" required id="barangay" placeholder="{{ $data['user']->barangay }}" value="{{ $data['user']->barangay }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city" class="col-form-label">City: </label>
                                                <input type="text" name="city" class="form-control" required id="city" placeholder="{{ $data['user']->city }}" value="{{ $data['user']->city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="province" class="col-form-label">Province: </label>
                                                <input type="text" name="province" class="form-control" required id="province" placeholder="{{ $data['user']->province }}" value="{{ $data['user']->province }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip" class="col-form-label">Zip Code: </label>
                                                <input type="text" name="zip" class="form-control" id="zip" placeholder="1000" value="{{ $data['user']->zip }}">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="ladda-button btn btn-success">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/swal.js') }}"></script>
    <!-- Dashboard 1 init js -->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script type="text/javascript">
        update_values();

        function update_values() {
            let dropdown = $('#systemPriceDropdown');
            let costElement = $('#estimatedCost');
            let estimatedCostNetMeteringElement = $('#estimatedCostNetMetering');
            let savingsElement = $('#monthlySavings');
            let panelCountElement = $('#panelCount');
            let systemSizeElement = $('#systemSize');
            let annualSavingsElement = $('#annualSavings');
            let systemPeakElement = $('#systemPeak');
            let paybackInYearsElement = $('#paybackPeriod');
            let annualElectricityBillElement = $('#annualElectricityBill');
            let annualBillWithoutSolarElement = $('#annualBillWithoutSolar');

            let userBill = $('#bill_amount').val();
            let priceList = @json($data['price_list']);

            let closestMatch = priceList.reduce((prev, curr) => {
                return (Math.abs(curr.savings - userBill) < Math.abs(prev.savings - userBill) ? curr : prev);
            });

            let clientGoal = dropdown.find(':selected').val().toLowerCase();

            if (clientGoal === 'half' || clientGoal === 'full') {
                if (clientGoal === 'half') {
                    closestMatch.cost /= 2;
                    closestMatch.savings /= 2;
                    closestMatch.panels = Math.ceil(closestMatch.panels / 2);
                    closestMatch.size = (parseFloat(closestMatch.size) / 2).toFixed(1) + 'kwp';
                }

                let netMeteringCost = 30000;
                let paybackInYrs = closestMatch.cost / (closestMatch.savings * 12);
                let annualElectricityBill = (userBill - closestMatch.savings) * 12;
                let annualBillWithoutSolar = userBill * 12;

                costElement.html('₱ ' + numberWithCommas(parseInt(closestMatch.cost.toFixed(2))));
                savingsElement.html('₱ ' + numberWithCommas(closestMatch.savings.toFixed(2)));
                panelCountElement.html(closestMatch.panels);
                systemSizeElement.html(closestMatch.size);

                // Calculate and display the annual savings
                let annualSavings = closestMatch.savings * 12;
                annualSavingsElement.html('₱ ' + numberWithCommas(annualSavings.toFixed(2)));

                // Display the system peak in the table cell
                systemPeakElement.html(closestMatch.size);

                // Apply additional conditions
                if (clientGoal === 'full') {
                    // Full system with net metering
                    closestMatch.cost += netMeteringCost;
                }

                // Update values for estimated cost with net metering table
                estimatedCostNetMeteringElement.html('₱ ' + numberWithCommas(closestMatch.cost.toFixed(2)));

                // Update other values based on additional conditions
                paybackInYearsElement.html(paybackInYrs.toFixed(2));
                annualElectricityBillElement.html('₱ ' + numberWithCommas((annualElectricityBill.toFixed(2)) < 0 ? 0 : annualElectricityBill.toFixed(2)));
                annualBillWithoutSolarElement.html('₱ ' + numberWithCommas(annualBillWithoutSolar.toFixed(2)));
            } else {
                Alert.fire({
                    icon: 'warning',
                    title: 'Error in System Price',
                    text: 'Please enter "half" or "full" in the System Price field.'
                });
            }

            console.log("Price list: ", priceList);
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
