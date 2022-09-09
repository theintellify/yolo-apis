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
        $this->middleware('guest')->except('logout','authenticated');
      
    }

    protected function authenticated(Request $request, $user)
    {   
        $name = \Auth::user()->name;
        $email = \Auth::user()->email;     

        $otp = random_int(100000, 999999);
        $user = \Auth::user();
        $user->otp = (int)$otp;
        $user->save();
        $data = array('name'=>$name,'email'=>$email,'otp'=>$otp);
        \Mail::send('mail', ['data'=>$data], function($message) use($email) {
             $message->to($email, 'YoloH API OTP')->subject
                ('YoloH API OTP');
             $message->from('support@theintellify.net','YoloH API');
         }); 
         
         return redirect()->route('otp');
    }
   
}
