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
            </tbody>
        </table>
    </div>
</div>

