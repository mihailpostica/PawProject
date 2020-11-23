<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function Login(Request $request){
       $validatedData= $request->validate(
           [
               'email'=>['required'],
               'password'=>['required']
           ]
       );
       if (!Auth::attempt($validatedData)){
           return response(['message'=>'Invalid credentials']);
       }
       $accessToken=Auth::user()->createToken('api_token')->accessToken;
       return response(['user'=>Auth::user(),'accessToken'=>$accessToken]);
    }

    public function Register(Request $request){


    }


}
