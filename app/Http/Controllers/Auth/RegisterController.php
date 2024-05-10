<?php

namespace App\Http\Controllers\Auth;
use App\Models\Province;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use App\Traits\ProcessesFiles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ProcessesFiles, VerifiesEmails;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('pages.quotation.auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all());

        $verifyProvince = Province::query()
        ->where('name', 'like', '%'.$request->province.'%')
        ->first();

        if (!$verifyProvince){
            return redirect()
            ->back()
            ->withErrors('Service is not available in the area');
        }

        $request['bill'] = $this->uploadBill($request);

        try {
            event(new Registered($user = $this->create($request->all())));
        } catch (QueryException $exception) {
            return redirect()->back()->withErrors($exception->getMessage())->withInput($request->all());
        }

        Auth::guard('client')->login($user);

        if (!$request->user('client')->hasVerifiedEmail()) {
            return $this->showVerificationForm($request);
        }

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'mobile_number' => 'required',
            'alignment' => 'required',
            'average_bill' => 'required',
            'site_visit' => 'required',
            'bill' => ['required', 'file', 'image', 'max:2048'],
            'goal' => 'required',
            'status' => 'required',
        ]);
    }

    protected function create(array $data)
    {
        return Client::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $data['role_id'],
            'email' => $data['email'],
            'email_verified_at' => '',
            'password' => Hash::make($data['password']),
            'street' => $data['street'],
            'barangay' => $data['barangay'],
            'city' => $data['city'],
            'province' => $data['province'],
            'mobile_number' => $data['mobile_number'],
            'alignment' => $data['alignment'],
            'average_bill' => $data['average_bill'],
            'site_visit' => $data['site_visit'],
            'bill' => $data['bill'],
            'goal' => $data['goal'],
            'status' => $data['status']
        ]);
    }

    public function uploadBill(Request $request) {
        // Path where the bills are saved, also return the name of the bill to be restored in the database.
        $path = 'images/bills';

        return $this->storePhoto($request, $path, 'bills');
    }

    public function redirectPath()
    {
        if (Auth::guard('client')->check()) {
            return '/client/dashboard';
        }

        return '/admin/dashboard';
    }

    public function showVerificationForm(Request $request) {
        return $request->user('client')->hasVerifiedEmail()
            ? redirect()->route('dashboard')
            : view('pages.quotation.auth.confirmation');
    }
}
