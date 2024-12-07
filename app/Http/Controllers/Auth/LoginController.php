<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpLogin;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @throws ValidationException|RandomException
     */
    public function sendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return $this->sendFailedLoginResponse($request);
        }

        $otp_no = random_int(100000, 999999);
        $otp = OtpLogin::where('email', $request->email)->first();
        if ($user->is_active) {
            if ($otp == null) {
                OtpLogin::create([
                    'email' => $request->email,
                    'otp_number' => $otp_no,
                    'attempt_send' => 1,
                ]);
            } else {
                $now = new \DateTime();

                $last_send = $otp->created_at;
                $time_diff = $last_send->diff($now);
                $minutes = $time_diff->days * 24 * 60;
                $minutes += $time_diff->h * 60;
                $minutes += $time_diff->i;

                if ($otp->attempt_send >= 10) {
                    $min = 60 - $minutes;
                    if ($minutes < 60) {
                        return response()->json([
                            'type' => 'attempt',
                            'minutes' => $min,
                            'message' => 'Too many resend otp attempts. Please try again in ' . $min . 'minutes. If you need help, you can contact the administrator.',
                            'status' => 'Failed'
                        ]);
                    }
                }

                if ($minutes >= 5) {
                    OtpLogin::where('email', $otp->email)->update([
                        'otp_number' => $otp_no,
                        'attempt_send' => 1,
                        'created_at' => $now
                    ]);
                } else {
                    $attempt = $otp->attempt_send + 1;
                    OtpLogin::where('email', $otp->email)->update([
                        'attempt_send' => $attempt
                    ]);
                }
            }

            $otp = OtpLogin::where('email', $request->email)->first();
            $expired = strtotime($otp->created_at->format('Y-m-d H:i:s')) + (60 * 5);
            if (isset($request->verify)) {
                if ($request->verify == 1) {
                    $err_msg = 'Your data cannot be found, please contact the administrator.';
                } else {
                    $err_msg = 'OTP number is wrong';
                }

                return response()->json([
                    'type' => 'verify',
                    'expired_time' => date('M j, Y H:i:s', $expired),
                    'message' => $err_msg,
                    'status' => 'Failed'
                ]);
            } else {
                dispatch(new \App\Jobs\LoginOtp\SendEmailOtp($request, $otp));
            }

            $this->sendLoginResponse($request);
            return response()->json([
                'type' => 'email',
                'expired_time' => date('M j, Y H:i:s', $expired),
                'message' => 'Email has been sent',
                'status' => 'Success'
            ]);
        } else {
            Auth::logout();
            return $this->sendNotActiveLoginResponse($request);
        }
    }

    /**
     * @throws ValidationException
     */
    public function verifyOtp(Request $request)
    {
        $otp = OtpLogin::where('email', $request->email)->first();

        if ($otp == null) {
            $request->verify = 1;
            return $this->loginWithOtp($request);
        }

        if ($otp->otp_number == $request->otp_number && $otp->created_at->diffInSeconds(Carbon::now()) <= 300) {
            if ($this->attemptLogin($request)) {
                if (Auth::user()->is_active) {
                    $otp->delete();
                    return response()->json([
                        'type' => 'verify',
                        'login_time' => date('M j, Y H:i:s', strtotime(Carbon::now())),
                        'message' => 'OTP Success',
                        'status' => 'Success'
                    ]);
                } else {
                    Auth::logout();
                    return $this->sendNotActiveLoginResponse($request);
                }
            }
        } else {
            $request->verify = 2;
            return $this->sendOtp($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function loginWithOtp(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return $this->sendFailedLoginResponse($request);
        }
        if (!Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        // skip otp verify
        if(config('app.env') === 'development' || config('app.env') === 'staging') {
            if ($this->attemptLogin($request)) {
                if (Auth::user()->is_active) {
                    return $this->sendLoginResponse($request);
                } else {
                    Auth::logout();

                    return $this->sendNotActiveLoginResponse($request);
                }
            }
        }

        $email_response = $this->sendOtp($request)->getData();

        $this->data['otp'] = $request;
        $this->data['email_response'] = $email_response;

        if ($email_response->type === "attempt") {
            $this->fireLockoutEvent($request);
            throw ValidationException::withMessages([
                $this->username() => "Too many login attempts. Please try again in " . $email_response->minutes . " minutes",
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }
        if ($email_response->type === "verify") {
            return response()->json($email_response);
        }

        return view('vendor.backpack.base.auth.otp', $this->data);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if (Auth::user()->is_active) {
                return $this->sendLoginResponse($request);
            } else {
                Auth::logout();

                return $this->sendNotActiveLoginResponse($request);
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendNotActiveLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['This account is no longer active, please contact the administrator'],
        ]);
    }
}
