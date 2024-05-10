<?php

namespace App\Traits;

use App\Models\Action;
use App\Models\AuditLog;
use App\Models\Offer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

trait DataProcessors {
    public function create_temporary_password() : int {
        return mt_rand(100000, 999999);
    }

    public function get_address($client) : string {
        return $client->street . ' ' . $client->barangay . ' ' . $client->city . ' ' . $client->province . ' ' . $client->zip;
    }

    public function translate_visit_status($visit_status) : string {
        if ($visit_status == 'for_approval') {
            return "For Approval";
        } else if ($visit_status == 'rejected') {
            return "Rejected";
        } else if ($visit_status == 'approved') {
            return "Approved";
        } else if ($visit_status == 'done') {
            return "Site Visit Done";
        }

        return "Invalid Type";
    }

    public function translate_client_alignment($alignment) : string {
        if ($alignment == 'request') {
            return "Requesting";
        } else if ($alignment == 'rejected') {
            return "Rejected";
        } else if ($alignment == 'for_site_visit') {
            return "For Site Visit";
        } else if ($alignment == 'for_approval') {
            return "For Approval";
        } else if ($alignment == 'done') {
            return "Done Site Visit";
        }

        return "Invalid Alignment";
    }

    public function translate_transaction_type($transaction_type) : string {
        if ($transaction_type == 'cash') {
            return "Cash";
        } else if ($transaction_type == 'online') {
            return "Online";
        }
    }

    public function save_preliminary_contract(Request $request) {

    }

    public function get_recommended_panel($client) : array {
        $panels = Offer::query()->get()->toArray();

        $bill = $client['average_bill'];

        $closest_match = array_reduce($panels, function ($prev, $curr) use ($bill) {
            return (abs($curr['savings'] - $bill) < abs((!$prev['savings'] ? 0 : $prev['savings']) - $bill)) ? $curr : $prev;
        }, $panels[0]);

        $net_metering = 30000;
        $payback_in_years = $closest_match['cost'] / ($closest_match['savings'] * 12);
        $annual_bill = ($bill - $closest_match['savings']) * 12;
        $annual_bill_no_solar = $bill * 12;
        $annual_savings = $closest_match['savings'] * 12;
        $estimate_cost = $closest_match['cost'];

        if ($client['goal'] == 'half') {
            $closest_match['cost'] /= 2;
            $closest_match['savings'] /= 2;
            $closest_match['panels'] = ceil($closest_match['panels'] / 2);
            $closest_match['size'] = number_format((floatval($closest_match['size']) / 2));
        }

        if ($client['goal'] == 'full') {
            $estimate_cost = $closest_match['cost'] + $net_metering;
        }

        // cost, size, panels, savings belongs to offer
        // net metering is in the estimated cost
        $recommendation = [
            'client_id' => $client['id'],
            'offer_id' => $closest_match['id'],
            'monthly_savings' => $closest_match['savings'],
            'annual_savings' => $annual_savings,
            'estimated_cost' => $closest_match['cost'],
            'estimated_cost_with_net_metering' => $estimate_cost,
            'payback_period' => round($payback_in_years, 2),
            'annual_electricity' => ($annual_bill < 0 ? 0 : $annual_bill),
            'annual_electricity_bill_no_solar' => $annual_bill_no_solar
        ];

        return $recommendation;
    }

    public function log_action($user, $action, $sale) {
        $data = [
            'employee_id' => $user->id,
            'action_id' => $action->id,
            'remarks' => $action->description . ' of Sale ID: ' . $sale->id,
        ];

        try {
            AuditLog::create($data);
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }
    }
}
