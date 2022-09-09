<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function showOtp(){
        return view('admin.otp');
        //dd('show page');
    }

    public function verifyOtp(Request $request)
    { 
    	$otp = random_int(100000, 999999);
    	
        $otp = (int)$request->otp;
        $user = \Auth::user();
         
        if($otp===$user->otp){
            
            $user->otp = null;
            $user->save();

            return redirect()->route('admin.home');
        }else {
        	return redirect()->back()->with('error','Your OTP is Incorrect Try Again')->withInput($request->all());
         }
        
    }
}
