<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Sale;
use App\Models\User;
use App\Traits\DataProcessors;
use App\Traits\ProcessesFiles;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    use DataProcessors, ProcessesFiles;
    public function index(Request $request) {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $invoice['transaction_type'] = $this->translate_transaction_type($invoice->transaction_type);
        }

        $data = [
            'invoices' => $invoices
        ];

        return view('pages.quotation.admin.invoices.index', compact('data'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'sale_id' => 'required',
            'amount' => 'required',
            'transaction_type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $action = Action::query()
            ->findOrFail($request->input('action_id'));

        $request['payment_date'] = Carbon::now();

        $user = User::query()->findOrFail($request['user_id']);

        // If admin encodes the invoice, it is auto approve.
        if ($user->role->name == 'Admin') {
            $request['approval_status'] = 'approved';
        } else {
            $request['approval_status'] = 'pending';
        }

        // Get the full price
        $sale = Sale::query()->findOrFail($request['sale_id']);
        $request['full_price'] = $sale->estimated_cost_with_net_metering;

        // Check for existing records
        $existing_invoice = Invoice::where('sale_id', $request->sale_id)
            ->where('user_id', $request->user_id)
            ->latest()
            ->first();

        // If there are no existing invoice, get the latest and find the difference between the full price and the amount
        if (!$existing_invoice) {
            $request['remaining_balance'] = $request['full_price'] - $request['amount'];
        } else {
            // If there are existing invoice, subtract the remaining balance and the amount being paid
            $request['remaining_balance'] = $existing_invoice->remaining_balance - $request['amount'];
        }

        // For uploading the proof of payment image
        if ($request->hasFile('image')) {
            $path = 'images/proof_of_payments';

            $request['proof_of_payment'] = $this->storePhoto($request, $path, 'proof_of_payments');
        }

        try {
            $invoice = new Invoice($request->all());

            $invoice->save();
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $this->log_action($user, $action, $sale);

        if ($user->role->name != 'Admin') {
            return redirect()
                ->route('invoices.index')
                ->with('invoice_successfully_created_routed', true);
        } else {
            return redirect()
                ->route('invoices.index')
                ->with('invoice_created', true);
        }
    }

    public function show($id) {
        try {
            $invoice = Invoice::query()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $data = [
            'invoice' => $invoice
        ];

        return view('components.forms.update_invoice_form', compact('data'));
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'amount' => 'required',
            'transaction_type' => 'required',
        ]);

        try {
            $user = User::query()->findOrFail(Auth::user()->id);
            $action = Action::query()->findOrFail($request['action_id']);
            $sale = Sale::query()->findOrFail($request['sale_id']);
        } catch (ModelNotFoundException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $invoice = Invoice::query()->findOrFail($id);

        // Recompute the remaining balance
        $request['remaining_balance'] -= $request['amount'];

        // For uploading the proof of payment image
        if ($request->hasFile('image')) {
            $path = 'images/proof_of_payments';

            $request['proof_of_payment'] = $this->storePhoto($request, $path, 'proof_of_payments');
        }

        // Admin needs to verify the updated invoice
        if ($user->role->name != 'Admin') {
            $request['approval_status'] = 'pending';
        }

        $invoice->update($request->all());

        $this->log_action($user, $action, $sale);

        return redirect()
            ->route('invoices.index')
            ->with('invoice_updated', true);
    }

    public function delete($id) {
        try {
            $invoice = Invoice::query()->findOrFail($id);
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('invoice_deleted', true);
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

        return view('pages.quotation.admin.invoices.tracker', compact('data'));
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

        return view('pages.quotation.admin.invoices.print', compact('data'));
    }
}
