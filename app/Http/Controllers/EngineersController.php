<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Role;
use App\Models\User;
use App\Traits\DataProcessors;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EngineersController extends Controller
{
    use DataProcessors;

    public function index(Request $request) {
        $engineers = User::query()->where('role_id', '=', 2)->get();

        // This is used for the dropdown when assigning an engineer
        if ($request->ajax()) {
            return $engineers;
        }

        $data = [
            'employees' => $engineers
        ];

        return view('pages.quotation.admin.employees.index', compact('data'));
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email'
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception);
        }

        $temporary_password = $this->create_temporary_password();
        $request['password'] = Hash::make($temporary_password);
        $request['role_id'] = Role::query()->where('level', '=', 2)->first()->id;

        $user = new User($request->all());
        $user->save();

        $notification = [
            'subject' => 'Welcome to Sinag Araw Energy Solutions Inc. - Temporary Password',
            'company_name' => 'Sinag Araw Energy Solutions Inc.',
            'message' => ' --- An auto generated message, please do not reply --- <br><br> Welcome to the company, '.$user->first_name.'! <br> To get started here is your temporary password. <br><br> Password: '.$temporary_password.', <br><br> you may log in and change it here in this <a href="'.route('login').'">link</a>',
            'user' => $user
        ];

        try {
            // Send a notification
            SendEmail::dispatch($notification);
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->withErrors($exception);
        }

        return redirect()->route('engineers.index')->with('store_success', true);
    }

    public function update($id, Request $request) {
        try {
            $user = User::query()->findOrFail($id);

            $user->update($request->all());
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('update_success', true);
    }

    public function send_temporary_password(Request $request) {
        try {
            $this->validate($request, [
                'employee_id' => 'required|integer',
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception);
        }

        $id = $request['employee_id'];

        $temporary_password = $this->create_temporary_password();
        $request['password'] = Hash::make($temporary_password);

        // Make them reset their password with resetting the login counter.
        $request['logins'] = 0;

        try {
            $engineer = User::query()->findOrFail($id);
            $engineer->update($request->all());
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        // Send a notification for the engineer about the reset password.
        $notification = [
            'subject' => 'Sinag Araw Energy Solutions Inc. - Employee Reset Password',
            'company_name' => 'Sinag Araw Energy Solutions Inc.',
            'message' => ' --- An auto generated message, please do not reply --- <br><br> Hello, '.$engineer->first_name.'! <br> You have requested a password reset and here\'s the temporary password. <br><br> Password: '.$temporary_password.', <br><br> you may log in and change it here in this <a href="'.route('login').'">link</a>',
            'user' => $engineer
        ];

        SendEmail::dispatch($notification);

        return redirect()
            ->back()
            ->with('reset_password_sent', true);
    }

    public function change_password() {
        $user = Auth::user();

        $login_attempts = $user->logins;

        // means it's the first time they're logging in,
        if ($login_attempts == 1) {
            return view('pages.quotation.admin.employees.update_password');
        }

        return redirect()->route('engineers.index');
    }

    public function update_password($id, Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::query()->findOrFail($id);

        $password_match = Hash::check($request['old_password'], $user['password']);

        $reused_password = Hash::check($request['password'], $user['password']);

        if ($password_match) {
            if ($reused_password) {
                return redirect()
                    ->back()
                    ->withErrors('The password has already been used, please enter a different password.');
            }

            $user['password'] = Hash::make($request['password']);

            $user->save();

            return redirect()
                ->route('admin.dashboard')
                ->with('update_password_success', true);
        }

        return redirect()
            ->back()
            ->withErrors('The current password does not match');
    }
}
