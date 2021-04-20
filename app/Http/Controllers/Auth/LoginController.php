<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;

use Auth;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "admin/dash";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        // var_dump($user->password);die;


        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($fieldType, '=', $input['username'])->first();

        if ($user) {
            auth()->loginUsingId($user->id);
            return $this->sendLoginResponse($request);
            //return redirect()->route('home');
        } else {
            $validator->errors()->add('username', 'These credentials do not match our records.');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        if (!isset($user)) {
            return false;
        }

        Auth::login($user);

        return true;
    }


    protected function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        $user = User::where($fieldType, '=', $input['username'])->first();

        if (Hash::check($input['password'], $user->password)) {

            $request->session()->regenerate();
            // var_dump(session()->getID());die;
            auth()->loginUsingId($user->id, true);

            $user->last_session = session()->getID();

            $user->save();
            // var_dump(auth()->user()->type===1);die;
            return $this->sendLoginResponse($request);
            //return redirect()->route('home');
        } else {
            $validator->errors()->add('username', 'These credentials do not match our records.');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }
    }

    protected function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    protected function sendLoginResponse(Request $request)
    {

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
