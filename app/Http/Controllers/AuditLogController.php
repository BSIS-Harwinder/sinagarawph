<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AuditLogController extends Controller
{
    public function index() {
        if (Auth::user()->role->name != "Admin") {
            return redirect()
                ->back()
                ->withErrors('Unauthorized Access!');
        }

        return view('pages.quotation.admin.audit');
    }

    public function datatable(Request $request) {
        $auditLogs = AuditLog::query()
            ->orderBy('id', 'desc')
            ->get();

        foreach ($auditLogs as $log) {
            $log->employee_name = $log->employee->first_name . ' ' . $log->employee->last_name;

            if ($log->action != null) {
                $log->action_description = $log->action->code;
            } else {
                $log->action_description = 'Not available';
            }

            if ($log->reason != null) {
                $log->reason_description = $log->reason->code;
            } else {
                $log->reason_description = 'Not available';
            }
        }

        $datatables = DataTables::of($auditLogs);

        return $datatables->make(true);
    }
}
