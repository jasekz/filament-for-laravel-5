<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Request;
use Validator;

class AuthController extends Controller {
    
    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth            
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->loginPath = route('admin.auth.login');
        $this->redirectPath = route('admin.dashboard');
        
        $this->middleware('guest.admin', [
            'except' => 'getLogout'
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request            
     * @return \Illuminate\Http\Response
     */
    public function postLogin(\Illuminate\Http\Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->ajaxErrors($validator->messages()
                ->toArray(), trans('app.correctErrors'));
        }
        
        $credentials = $request->only('email', 'password');
        
        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return $this->ajaxSuccess(trans('app.welcome'), [
                'redirect' => $this->redirectPath()
            ]);
        }
        
        return $this->ajaxError(trans('app.loginFailure'));
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();
        
        return redirect($this->loginPath);
    }
}
