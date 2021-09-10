<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->user = new User;
    }

    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'phone' => 'required|regex:/[0-9]{10}/|digits:10',            
        ]);

        $credentials = $request->only('phone', 'password');
        $credentials['role'] = ['EMPLOYEE','ADMIN'];

        if (\Auth::attempt($credentials)) {
            // Authentication passed...
            if(\Auth::user()->isAdmin())
                return redirect()->route('admins.dashboard.index');
                    else{
                        \Auth::logout();
                        return back()->withErrors(['credentials' => __('lang.invalid_credentials')]);
                    }  
        } else {
            return back()->withErrors(['credentials' => __('lang.invalid_credentials')]);
        }
        
    }
}
