<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Sale;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\DataProcessors;
use App\Traits\ProcessesFiles;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{
    use DataProcessors, ResetsPasswords, ProcessesFiles;

    public function index(Request $request) {
        $user = Auth::user();

        $price_list = Offer::query()
            ->get();

        $data = [
            'user' => $user,
            'panels' => $price_list,
            'price_list' => $price_list->toArray()
        ];

        return view('pages.quotation.client.index', compact('data'));
    }

    public function show_profile($id) {
        //
    }

    public function update($id, Request $request) {
        try {
            $client = Client::query()->findOrFail($id);
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        // For file uploading.
        if ($request->hasFile('image')) {
            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];

            $messages = [
                'image.max' => 'The size of :attribute is too big, maximum of 2MB is allowed',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            ];

            $request->validate($rules, $messages);

            try {
                $request['bill'] = $this->storePhoto($request, 'images/bills', 'bills');
            } catch (FileException $exception) {
                return redirect()
                    ->back()
                    ->withErrors($exception->getMessage());
            }

            $client->update($request->all());

            return redirect()
                ->back()
                ->with('bill_upload_success', true);
        }

        $client->update($request->all());

        return redirect()
            ->back()
            ->with('update_success', true);
    }

    public function delete($id) {
        // Obsolete
    }

    public function show_request_reset_password() {
        return view('pages.quotation.auth.forgot');
    }

    public function send_password_link(Request $request) {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $response = Password::broker('clients')->sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
                    ? $this->send_reset_link_response($request, $response)
                    : $this->send_reset_link_failed($request, $response);
    }

    public function send_reset_link_response(Request $request, $response) {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('status', trans($response));
    }

    public function send_reset_link_failed(Request $request, $response) {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    public function reset_password(Request $request)
    {
        try {
            $this->validate($request, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => ['required', 'confirmed', 'min:6'],
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $response = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
                $user->password = Hash::make($password);

                $user->setRememberToken(Str::random(60));

                $user->save();
        });

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    public function redirectPath() {
        return '/client/login';
    }

    public function my_orders(Request $request) {
        $orders = Schedule::query()->where('client_id', '=', Auth::id())
            ->get();

        foreach ($orders as $order) {
            $order->site_visit_status = $this->translate_visit_status($order->visit_status);

            if (!$order->employee) {
                $order->employee_name = 'No assigned engineer';
            } else {
                $order->employee_name = $order->employee->first_name . ' ' . $order->employee->last_name;
            }
        }

        $data = [
            'orders' => $orders
        ];

        return view('pages.quotation.client.invoice.index', compact('data'));
    }

    public function view_order($invoice_number, Request $request) {
        $sale = Sale::query()->findOrFail($invoice_number);

        $sale->schedule->client->address = $this->get_address($sale->schedule->client);

        $data = [
            'sale' => $sale
        ];

        return view('pages.quotation.client.invoice.show', compact('data'));
    }

    public function schedule_visit(Request $request) {
        try {
            $this->validate($request, [
                'client_id' => 'required',
                'visit_date' => 'required',
            ]);
        } catch (ValidationException $exception) {
            return back()->withInput($request->all())->withErrors($exception->getMessage());
        }

        $visit_date = Carbon::parse($request['visit_date']);
        $current_date = Carbon::now();

        if ($visit_date < $current_date) {
            return back()->withErrors('Visit date must not be from the past');
        } else if ($visit_date > $current_date->addMonths(2)) {
            return back()->withErrors('Visit date must be within 2 months');
        }

        $request['visit_status'] = 'for_approval';
        $admin = User::query()->where('role_id', '=', 1)->first();
        $user = Auth::user();

        // check if the client has an existing schedule for approval
        $existing_schedules = Schedule::query()
            ->where('client_id', '=', $request['client_id'])
            ->where('visit_status', 'like', '%for_approval%')
            ->count();

        if ($existing_schedules > 0) {
            return back()->withErrors('A schedule has already filed and it is for approval please check back later.');
        }

        try {
            // Updating the client's alignment depending on the status of the client in the system whether
            // requesting for quotation, scheduled a site visit, or if done. So if the admin rejected the schedule, it will return to for_reschedule
            $client = Client::query()->findOrFail($request['client_id']);
            $params = [
                'alignment' => 'for_approval'
            ];
            $client->update($params);

            $recommendation = $this->get_recommended_panel($client);

            $contract = new Sale($recommendation);
            $contract->save();

            $request['sale_id'] = $contract['id'];

            // Attach the relationships between sale and schedule.
            $schedule = new Schedule($request->all());
            $schedule->save();
        } catch (QueryException $exception) {
            return back()->withInput($request->all())->withErrors($exception->getMessage());
        }

        $notification = [
            'subject' => 'Client has scheduled a site visit',
            'company_name' => 'Sinag Araw Energy Solutions Inc.',
            'message' => 'A client has scheduled a site visit, you may view here in this <a href="'.route('schedules.show', $schedule->id).'">link</a>',
            'user' => $admin
        ];

        $client_notification = [
            'subject' => 'Site visit acknowledged!',
            'company_name' => 'Sinag Araw Energy Solutions Inc.',
            'message' => 'You have scheduled a site visit, you may view here in this <a href="'.route('client.dashboard').'">link</a>',
            'user' => $user
        ];

        try {
            // Send a notification to the admin and client
            SendEmail::dispatch($notification);
            SendEmail::dispatch($client_notification);
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        // 20240424 edited by winder redirect to client order after setting the schedule
        // return back()->with('schedule_success', true);
        return redirect()->route('client.orders')->with('schedule_success', true);
    }

    public function invoice_tracker($sale_id) {
        try {
            $sale = Sale::query()->findOrFail($sale_id);
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $sale['remaining_balance'] = ($sale->estimated_cost_with_net_metering - $sale->invoice->where('approval_status', '=', 'approved')->pluck('amount')->sum());
        $sale['full_price'] = $sale->estimated_cost_with_net_metering;
        $sale['payment_status'] = ($sale['remaining_balance'] == 0 ? 'Paid' : 'Unpaid');

        $data = [
            'sale' => $sale
        ];

        return view('pages.quotation.client.invoice.tracker', compact('data'));
    }

    public function tracker_datatable($sale_id) {
        $invoices = Invoice::query()
            ->where('sale_id', $sale_id)
            ->get();

        foreach ($invoices as $invoice) {
            $invoice->transaction_type = $this->translate_transaction_type($invoice->transaction_type);
        }

        $datatable = DataTables::of($invoices);

        return $datatable->make(true);
    }

    public function print_invoice($id, Request $request) {
        try {
            $sale = Sale::query()->findOrFail($id);
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $data = [
            'sale' => $sale
        ];

        return view('pages.quotation.client.invoice.print', compact('data'));
    }
}
