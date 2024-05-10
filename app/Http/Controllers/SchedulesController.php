<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Client;
use App\Models\Reason;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\DataProcessors;
use App\Traits\ProcessesFiles;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SchedulesController extends Controller
{
    use DataProcessors, ProcessesFiles;

    public function index(Request $request) {
        $schedules = Schedule::query()->get();

        foreach ($schedules as $schedule) {
            if (!$schedule->employee) {
                $schedule->employee_name = 'No assigned engineer';
            } else {
                $schedule->employee_name = $schedule->employee->first_name . ' ' . $schedule->employee_last_name;
            }

            $schedule->visit_status = $this->translate_visit_status($schedule->visit_status);
        }

        $data = [
            'schedules' => $schedules
        ];

        return view('pages.quotation.admin.schedules.index', compact('data'));
    }

    public function show($id) {
        $schedule = Schedule::query()->findOrFail($id);

        $data = [
            'schedule' => $schedule,
            'client' => $schedule->client
        ];

        return view('pages.quotation.admin.schedules.show', compact('data'));
    }

    public function store(Request $request) {

    }

    public function update($id, Request $request) {
        $visit_status = $request['visit_status'];

        if ($visit_status == 'approve') {
            try {
                $this->validate($request, [
                    'employee_id' => 'required',
                    'visit_status' => 'required',
                ]);
            } catch (ValidationException $exception) {
                return back()->withInput($request->all())->withErrors($exception->getMessage());
            }

            $request['visit_status'] = 'approved';

            try {
                $schedule = Schedule::query()->findOrFail($id);
                $schedule->update($request->all());

                $client = Client::query()->findOrFail($schedule->client->id);
                $params = [
                    'alignment' => 'for_site_visit'
                ];

                $client->update($params);

                $engineer = $schedule->employee;
            } catch (QueryException $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            $engineerNotification = [
                'subject' => 'You have a new client for site visit',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Hi '. $engineer->email .'! You have been assigned for a site visit. Click <a href="'.route('client.dashboard').'">here</a> for the client\'s information.',
                'user' => $engineer
            ];

            $notification = [
                'subject' => 'Your scheduled site visit has been approved!',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Your scheduled site visit has been approved, access your account <a href="'.route('client.dashboard').'">here</a>.',
                'user' => $client
            ];

            // Send a notification
            try {
                SendEmail::dispatch($notification);
                SendEmail::dispatch($engineerNotification);
            } catch (Exception $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            return back()->with('schedule_update_success_approved', true);
        } else if ($visit_status == 'reject') {
            try {
                $this->validate($request, [
                    'visit_status' => 'required',
                ]);
            } catch (ValidationException $exception) {
                return back()
                    ->withInput($request->all())
                    ->withErrors($exception->getMessage());
            }

            $request['visit_status'] = 'rejected';

            try {
                $schedule = Schedule::query()->findOrFail($id);
                $schedule->update($request->all());


                $client = Client::query()->findOrFail($schedule->client->id);
                $params = [
                    'alignment' => 'rejected'
                ];

                $client->update($params);

                $id = $request['reason_id'];
                $reason = Reason::query()->findOrFail($id);
            } catch (QueryException $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            $notification = [
                'subject' => 'Site visit has been rejected.',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'We apologize that your scheduled site visit has been rejected due to this reason; <br><br> '.$reason['description'].' <br><br> please file for another schedule in your <a href="'.route('client.dashboard').'">account</a>.',
                'user' => $client
            ];

            try {
                SendEmail::dispatch($notification);
            } catch (Exception $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            return back()->with('schedule_update_success_rejected', true);
        } else if ($visit_status == 'done') {
            try {
                $this->validate($request, [
                    'visit_status' => 'required',
                    'remarks' => 'required',
                    'image' => 'required|file|image'
                ]);
            } catch (ValidationException $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            try {
                $request['confirmation_image'] = $this->storePhoto($request, 'images/site_visits', 'site_visits');

                $schedule = Schedule::query()->findOrFail($id);
                $schedule->update($request->all());


                $client = Client::query()->findOrFail($schedule->client->id);
                $params = [
                    'alignment' => 'done'
                ];

                $client->update($params);

                $engineer = $schedule->employee;

                $admin = User::query()->where('role_id', '=', '1')->first();
            } catch (QueryException $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            $engineerNotification = [
                'subject' => 'Site visit completion',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Hello, '.$engineer->email.'! <br><br> This is to acknowledge that you have completed the site visit for client ' . $client->first_name .'&nbsp;' . $client->last_name .'. Check your <a href="'.route('clients.index').'">clients dashboard</a> for more information.',
                'user' => $engineer
            ];

            $notification = [
                'subject' => 'Site visit has been completed.',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Good day! We heard that the site visit is finished, wait for our team to get in touch with you while we are finalizing the contract, you can check your <a href="'.route('client.dashboard').'">account</a> for updates.',
                'user' => $client
            ];

            $adminNotification = [
                'subject' => 'Site visit has been completed.',
                'company_name' => 'Sinag Araw Energy Solutions Inc.',
                'message' => 'Hi, '. $admin->first_name .'! A site visit has been completed by '.$engineer->first_name.', you can check your <a href="'.route('clients.index').'">clients</a> in the dashboard for more information.',
                'user' => $admin
            ];

            try {
                SendEmail::dispatch($notification);
                SendEmail::dispatch($engineerNotification);
                SendEmail::dispatch($adminNotification);
            } catch (Exception $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            return back()->with('update_success', true);
        }

        return redirect()->back()->withErrors('[SchedulesController] Unknown request, please contact developer');
    }

    public function delete($id) {
        try {
            $schedule = Schedule::query()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return redirect()->withErrors($exception->getMessage());
        }

        $schedule->delete();

        return redirect()->with('delete_success')->route('schedules.index');
    }

    public function engineer_schedule() {
        return view('pages.quotation.engineer.schedule.index');
    }

    public function view_schedule(Request $request) {
        try {
            $this->validate($request, [
                'from' => 'required',
                'to' => 'required'
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $id = Auth::id();
        $engineer = User::query()->findOrFail($id);

        $from = ($request['from'] == '' ? Carbon::minValue() : $request->get('from'));
        $to = ($request['to'] == '' ? Carbon::now() : $request->get('to'));

        $schedules = Schedule::query()
            ->where('employee_id', '=', $engineer->id)
            ->where('visit_status', '=', 'approved')
            ->whereDate('visit_date', '>=', $from)
            ->whereDate('visit_date','<=', $to)
            ->get();

        foreach ($schedules as $schedule) {
            $schedule->visit_status = $this->translate_visit_status($schedule->visit_status);
            $schedule->client->alignment = $this->translate_client_alignment($schedule->client->alignment);
        }

        $data = [
            'schedules' => $schedules
        ];

        return view('pages.quotation.engineer.schedule.view', compact('data'));
    }
}
