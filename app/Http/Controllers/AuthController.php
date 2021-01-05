<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function Login(Request $request){

            $rules=array(
                'email'=>'required',
                'password'=>'required',
            );
            $messages=array(
                'email.required' => 'Please enter an email.',
                'password.required' => 'Please enter a a password.',
            );
            $validator=Validator::make($request->all(),$rules,$messages);
            if($validator->fails())
            {
                $messages=$validator->messages();
                $errors=$messages->all();
                return response()->json(['errors'=>$errors],500);
            }
       if (!Auth::attempt($request->all())){
           return response()->json(['errors'=>['Invalid credentials']],200);
       }
        $role=Auth::user()->rol->rol_name;
        $id=Auth::id();
        $user=User::Where(['id'=>$id])->with('Categorii')->first();
       $accessToken=Auth::user()->createToken('api_token',[$role])->accessToken;
       return response()->json(['user'=>$user,'accessToken'=>$accessToken],200);
    }


    public function Register(Request $request){
        $rules=array(
            'nume' => ['required', 'string', 'max:255'],
            'prenume' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        );

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['errors'=>$errors],500);
        }
        $user=User::create(array_merge($request->all(), ['imagine'=>'default.png','rol_id'=>'1']));
        $categories = $request->preferinte;
        if (is_array($categories) || is_object($categories)) {
            foreach ($categories as $categorie) {
                $user->Categorii()->attach($categorie);
            }
        }
        if($user){
            return response()->json(['success'=>'true','message'=>'User Created successfully'],201);
        }else{
            return response()->json(['success'=>'false','message'=>'Something went wrong'],500);
        }
    }

    public function Users(){
        return User::all();
    }
    public function getUser(){
        $id=Auth::id();
        $user=User::Where(['id'=>$id])->with('Categorii')->first();
        return response()->json(['user'=>$user],200);
    }

    public function Categorii(){
        $user=Auth::user();
        return response()->json(['preferinte'=>$user->Categorii]);
    }
    public function addCategorii(Request $request)
    {
        $user = Auth::user();
        $categories = $request->categorii;
        if (is_array($categories) || is_object($categories)) {

            foreach ($categories as $categorie) {
                $user->Categorii()->attach($categorie);
            }
            if(count($categories)>0){
                return response()->json(['success'=>true,'message'=>'preferences added successfully'],200);
            }

        }
        return response()->json(['success'=>true,'message'=>'nothing was added, empty array'],200);
    }

    public function updateUser(Request $request){
        $preferinte=$request->preferinte;
        if(is_array($preferinte)) {
            if (count($preferinte)>0){
                Auth::user()->Categorii()->detach();
                foreach ($preferinte as $preferinta){
                    Auth::user()->Categorii()->attach($preferinta);
                }
            }
            }
        Auth::user()->update(['nume'=>$request->nume,'prenume'=>$request->prenume]);
        return response()->json(['message'=>'information updated successfully'],200);
    }


}
