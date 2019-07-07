<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Email;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public $successStatus = 200;

     /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        // check validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails())
            return response()->json(['error'=>$validator->errors()], 401);

        //create user
        $token = User::createUser($request->all());

        return response()->json($token, $this->successStatus);
    }
}
