<div class="card-box">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <img src="{{ asset('images/sinag.png') }}" alt="Sinag araw" width="275px">
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center text-uppercase">
            <div class="h1">{{ __('constants.company_name') }}</div>
        </div>
    </div>

    @include('components.contract.client_information')

    <div class="mb-3 text-center">
        <p class="h4">{{ __('constants.reducing_carbon_footprint_text') }}</p>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th class="h3 my-2 text-dark text-uppercase bg-warning">I. Solar Package</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('components.contract.grid-tie-package')

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th class="h3 my-2 text-dark text-uppercase bg-warning">II. Payment Terms</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('components.contract.payment_terms')

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th class="h3 my-2 text-dark text-uppercase bg-warning">Bank Details</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('components.contract.bank_details')

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th class="h3 my-2 text-dark text-uppercase bg-warning">III. Scope and Conditions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('components.contract.scope')

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <th class="h3 my-2 text-dark text-uppercase bg-warning">IV. Tender Approval</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('components.contract.signatory')
</div>
