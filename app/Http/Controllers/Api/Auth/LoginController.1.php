<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public $successStatus = 200;
    public $maxAttempts = 5; // change to the max attemp you want.
    /**
     * login api
     *c
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            if(Auth::user()->email_verified_at != null)
                return response()->json(['token' => Auth::user()->createToken('MyApp')-> accessToken], $this-> successStatus);

            return response()->json(['error'=>'Email Verification'], 402);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
}
