<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\HaciendaAuthenticationService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HaciendaAuthenticationService $haciendaAuthenticationService)
    {
        $this->middleware('guest')->except('logout');
        $this->setting = \App\Setting::first();
        $this->haciendaAuthenticationService = $haciendaAuthenticationService;
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            // $obligadoTributario = $this->setting ? $this->setting->getObligadoTributario() : null;

            // if($obligadoTributario){
            //         try {

            //             $tokenData = $this->haciendaAuthenticationService->getPasswordToken($obligadoTributario->atv_user, $obligadoTributario->atv_password);
            
            //             $obligadoTributario->fill([
            //                 'grant_type' => $tokenData->grant_type,
            //                 'access_token' => $tokenData->access_token,
            //                 'refresh_token' => $tokenData->refresh_token,
            //                 'token_expires_at' => $tokenData->token_expires_at,
            //                 'refresh_expires_at' => $tokenData->refresh_expires_at,
            //             ]);

            //             $obligadoTributario->save();

            //         } catch (ClientException $e) {
            //             $message = $e->getResponse()->getBody();

            //             if (Str::contains($message, 'invalid_credentials')) {
            //                 \Log::error('Error Get Password Token Login invalid_credentials', json_encode($message));
            //             }
            
            //            \Log::error('Error Get Password Token Login', json_encode($message));
            //         }
            // }


            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $obligadoTributario = $this->setting ? $this->setting->getObligadoTributario() : null;

        if($obligadoTributario){
            try {

                // $this->haciendaAuthenticationService->logout($obligadoTributario);

            } catch (ClientException $e) {
                $message = $e->getResponse()->getBody();

                \Log::error('Error Logout Token: '. json_encode($message));
            }
           
        }


        $this->guard()->logout();

        $request->session()->invalidate();

        

        return $this->loggedOut($request) ?: redirect('/');
    }
}
