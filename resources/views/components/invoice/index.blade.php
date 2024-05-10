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


    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="text-uppercase text-white bg-warning">Client</th>
                    <th scope="col">{{ $sale->schedule->client->first_name }} {{ $sale->schedule->client->last_name }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="text-uppercase text-white bg-warning">Contact Number</th>
                    <th>{{ $sale->schedule->client->mobile_number }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase text-white bg-warning">Client Address</th>
                    <th>{{ $sale->schedule->client->address }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase text-white bg-warning">Email Address</th>
                    <th>{{ $sale->schedule->client->email }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase text-white bg-warning">Full Amount</th>
                    <th>{{ $sale->estimated_cost_with_net_metering }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="text-uppercase">Amount</th>
                    <th scope="col" class="text-uppercase">Running Balance</th>
                    <th scope="col" class="text-uppercase">Transaction Type</th>
                    <th scope="col" class="text-uppercase">Payment Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['sale']->invoice as $invoice)
                    <tr>
                        <th>{{ number_format($invoice->amount) }}</th>
                        <th>{{ number_format($sale->estimated_cost_with_net_metering -= $invoice->amount) }}</th>
                        <th>{{ ucfirst($invoice->transaction_type) }}</th>
                        <th>{{ date('F d, Y h:i:a', strtotime($invoice->payment_date)) }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

