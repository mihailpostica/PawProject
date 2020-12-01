<?php

namespace App\Http\Controllers;


use App\Models\Roluri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;


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

        $role=Auth::user()->rol->rol_name;

       $accessToken=Auth::user()->createToken('api_token',[$role])->accessToken;
       return response(['user'=>Auth::user(),'accessToken'=>$accessToken]);
    }

    public function Register(Request $request){
    User::Create ($request->all());
    return "user created";
    }

    public function createRol(Request $request){
       $rol=new Roluri();
       $rol->rol_name=$request->rol;
       $rol->save();
       return "role created";

    }

    public function Users(Request  $request){
        return User::all();
    }


}
