<div class="row my-2">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" colspan="2" class="text-uppercase bg-warning text-dark text-center h1">Grid-Tie Solar Package</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: forestgreen;">
                    <th class="text-uppercase text-light">System Price</th>
                    <th class="h2 text-light">₱{{ number_format($sale->estimated_cost, 2) }}</th>
                </tr>
                <tr style="background-color: forestgreen;">
                    <th class="text-uppercase text-light">System Price w/ Net Metering ***</th>
                    <th class="h2 text-light">₱{{ number_format($sale->estimated_cost_with_net_metering, 2) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row my-2">
    <div class="col-12">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th rowspan="9" class="text-center h4 align-content-center">Standard Terms</th>
                </tr>
                <tr>
                    <th class="text-uppercase text-center align-content-center">Grid-Tie Solar Package</th>
                    <th></th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost * 0.20), 2) }}</th>
                    <th>20% upon signing of contract and reservation of installation date</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost * 0.20), 2) }}</th>
                    <th>20% after on-site delivery of solar panels</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost * 0.20), 2) }}</th>
                    <th>20% after on-site delivery of other system components</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost * 0.30), 2) }}</th>
                    <th>30% upon installation</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost * 0.10), 2) }}</th>
                    <th>10% upon commissioning and testing</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format(($sale->estimated_cost_with_net_metering - $sale->estimated_cost), 2)  }}</th>
                    <th>Net Metering Fee</th>
                </tr>
                <tr>
                    <th>₱ {{ number_format($sale->estimated_cost_with_net_metering, 2) }}</th>
                    <th class="text-uppercase">Total</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
