<?php

namespace App\Http\Controllers\Api;

use App\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    public function store(Request $request){
        Charge::create(["user_id" => Auth::user()->id,"price" => $request->price]);
    }
}
