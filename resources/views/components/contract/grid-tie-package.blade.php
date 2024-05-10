<div class="row mt-2 mb-3">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" colspan="4" class="text-uppercase bg-secondary text-dark text-center h1">Grid-Tie Solar Package</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">System Peak</th>
                    <th class="bg-warning">{{ $sale->panel->size }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">Monthly Savings**</th>
                    <th class="bg-warning">₱{{ number_format($sale->monthly_savings, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">Annual Savings**</th>
                    <th class="bg-warning">₱{{ number_format($sale->annual_savings, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">Annual Electric Bill**</th>
                    <th class="bg-warning">₱{{ number_format($sale->annual_electricity, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">System Price</th>
                    <th class="bg-success h2">₱{{ number_format($sale->estimated_cost, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">System Price w/ Net Metering ***</th>
                    <th class="bg-success h2">₱{{ number_format($sale->estimated_cost_with_net_metering, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-uppercase" style="background-color: salmon">Payback Method w/ Net Metering</th>
                    <th class="bg-warning">{{ $sale->payback_period }} yrs</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-2 mb-4">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="3" class="text-uppercase bg-secondary text-dark text-center h1">Bill of Materials***</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <th style="background-color: lightgreen">Materials</th>
                    <th style="background-color: lightgreen">Description</th>
                    <th style="background-color: lightgreen">Quantity</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Solar Panels</th>
                    <th style="background-color: yellowgreen">Canadian Mono 545W</th>
                    <th style="background-color: yellowgreen">10</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Power Inverter</th>
                    <th style="background-color: yellowgreen">Single 6kW Phase Inverter</th>
                    <th style="background-color: yellowgreen">1</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Railings and Mountings</th>
                    <th style="background-color: yellowgreen">Complete Mounting Set</th>
                    <th style="background-color: yellowgreen">1 Lot</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Wires & Protective Devices</th>
                    <th style="background-color: yellowgreen">Wires, Breakers, SPD., Etc.</th>
                    <th style="background-color: yellowgreen">1 Lot</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="3" class="text-uppercase bg-secondary text-dark text-center h1">Warranty and Performance Guarantee</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <th style="background-color: salmon">Solar Panels</th>
                    <th style="background-color: yellowgreen">Manufacturer's Warranty</th>
                    <th style="background-color: yellowgreen">10 years</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Power Inverter</th>
                    <th style="background-color: yellowgreen">Manufacturer's Warranty</th>
                    <th style="background-color: yellowgreen">5 years</th>
                </tr>
                <tr class="text-center">
                    <th style="background-color: salmon">Railings and Mountings</th>
                    <th style="background-color: yellowgreen">Engineering and Workmanship warranty</th>
                    <th style="background-color: yellowgreen">2 years</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
