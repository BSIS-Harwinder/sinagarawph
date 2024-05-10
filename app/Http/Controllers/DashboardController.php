<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Sale;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\DataProcessors;
use App\Traits\ProcessesFiles;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    use DataProcessors, ProcessesFiles;

    public function index(Request $request) {
        $user = Auth::user();

        $user_level = $user->role->level;

        // For the engineer
        if ($user_level == 2) {
            foreach ($user->schedule as $schedule) {
                $schedule->client->address = $this->get_address($schedule->client);
                $schedule->client_alignment = $this->translate_client_alignment($schedule->client->alignment);
            }


            $data = [
                'user' => $user
            ];

            return view('pages.quotation.engineer.index', compact('data'));
        }

        $employees = User::query()
            ->where('role_id', '=', 2)
            ->get();

        $clients = Client::query()
            ->has('schedule')
            ->get();

        $pending_clients = Client::query()
            ->whereNull('email_verified_at')
            ->where('status', '=', 'pending')
            ->get();

        $approved_site_visits = Schedule::query()
            ->where('visit_status', '=', 'approved')
            ->count();

        foreach ($clients as $client) {
            $client->address = $this->get_address($client);
            $client->visit_status = $this->translate_visit_status($client->schedule->last()->visit_status);
        }

        $data = [
            'user' => $user,
            'employees' => $employees,
            'clients' => $clients,
            'pending_clients' => $pending_clients,
            'site_visits_count' => $approved_site_visits
        ];

        return view('pages.quotation.admin.index', compact('data'));
    }

    public function contract(Request $request) {
        $user_level = Auth::user()->role->level;

        if ($user_level == 2) {
            $sales = Schedule::query()->where('employee_id', '=', Auth::id())
                ->get();
        } else {
            $sales = Schedule::query()->get();
        }

        foreach ($sales as $sale) {
            $sale->site_visit_status = $this->translate_visit_status($sale->visit_status);

            if (!$sale->employee) {
                $sale->employee_name = 'No assigned engineer';
            } else {
                $sale->employee_name = $sale->employee->first_name . ' ' . $sale->employee->last_name;
            }

            $sale->client_name = $sale->client->first_name . ' ' . $sale->client->last_name;
        }

        $data = [
            'schedules' => $sales
        ];

        return view('pages.quotation.admin.contracts.index', compact('data'));
    }

    public function view_contract($id, Request $request) {
        $sale = Sale::query()->findOrFail($id);

        $sale->visit_status = $this->translate_visit_status($sale->visit_status);

        if (!$sale->employee) {
            $sale->employee_name = 'No assigned engineer';
        } else {
            $sale->employee_name = $sale->employee->first_name . ' ' . $sale->employee->last_name;
        }

        $sale->schedule->client->address = $this->get_address($sale->schedule->client);

        $data = [
            'sale' => $sale
        ];

        return view('pages.quotation.admin.contracts.view', compact('data'));
    }

    public function list_clients(Request $request) {
        $clients = Client::query()->get();

        foreach ($clients as $client) {
            $client->has_image = $this->verifyPhotoLocation($client->bill, 'bills');
        }

        $data = [
            'clients' => $clients
        ];

        return view('pages.quotation.admin.clients.index', compact('data'));
    }

    public function show_client($id) {
        $client = Client::query()->findOrFail($id);

        $data = [
            'client' => $client
        ];

        return view('pages.quotation.admin.clients.show', compact('data'));
    }

    // Main purpose is to just approve / reject the bill
    public function update_client($id, Request $request) {
        try {
            $this->validate($request, [
                'bill_status' => 'required'
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        // Remove the bill from the database.
        if ($request['bill_status'] !== 'approved'){
            $request['bill'] = "";
        }
        try {
            $client = Client::query()->findOrFail($id);
            $client->update($request->all());
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        if ($request['bill_status'] !== 'approved'){
            $notification = [
                'subject' => 'Submitted Bill Rejected',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'We apologize that your submitted bill been rejected, please re-upload another bill in your <a href="'.route('client.dashboard').'">account</a>.',
                'user' => $client
            ];
        } else {
            $notification = [
                'subject' => 'Submitted Bill Approved',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Your submitted bill has been approved, <a href="'.route('client.dashboard').'">account</a>.',
                'user' => $client
            ];
        }

        SendEmail::dispatch($notification);

        return redirect()
            ->route('clients.index')
            ->with('update_success', true);
    }
}
