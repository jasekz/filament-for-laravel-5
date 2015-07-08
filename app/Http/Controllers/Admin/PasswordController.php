<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Validator;

class PasswordController extends Controller {
    
    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth            
     * @param \Illuminate\Contracts\Auth\PasswordBroker $passwords            
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectsTo = route('admin.dashboard');
        
        $this->middleware('guest.admin');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function getEmail()
    {
        return view('admin.password.getEmail');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request            
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        
        if ($validator->fails()) {
            return $this->ajaxErrors($validator->messages()
                ->toArray(), trans('app.correctErrors'));
        }
        
        $response = Password::sendResetLink($request->only('email'), function (Message $message)
        {
            $message->subject($this->getEmailSubject());
        });
        
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->ajaxSuccess(trans('app.genericSuccess'), [
                    'redirect' => route('admin.auth.login')
                ]);
            
            case Password::INVALID_USER:
                return $this->ajaxError(trans($response));
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param string $token            
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException();
        }
        
        return view('admin.password.getReset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request            
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);
        
        if ($validator->fails()) {
            return $this->ajaxErrors($validator->messages()
                ->toArray(), trans('app.correctErrors'));
        }
        
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        
        $response = Password::reset($credentials, function ($user, $password)
        {
            $this->resetPassword($user, $password);
        });
        
        switch ($response) {
            case Password::PASSWORD_RESET:
                return $this->ajaxSuccess(trans('app.genericSuccess'), [
                    'redirect' => route('admin.dashboard')
                ]);
            
            default:
                return $this->ajaxError(trans($response));
        }
    }
}
