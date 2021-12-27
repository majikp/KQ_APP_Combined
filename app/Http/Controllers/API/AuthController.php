<?php

//https://dev.to/shaileshjadav/laravel-8-rest-api-authentication-using-sanctum-3eb8
//https://devdocs-fr.github.io/laravel/7.x/sanctum#spa-authentication
//https://www.section.io/engineering-education/laravel-sanctum-api-auth/
//https://www.codecheef.org/article/laravel-sanctum-authentication-example-with-product-api
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|confirmed',
            'language'=>'required|string'
        ]);

        if($validator->fails()){
            return response([
                'status'=>false,
                'message'=> $validator->errors()
            ],401);
        }


        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'language'=>$request->language
        ]);

        // create token

        //$token=$user->createToken('myappToken')->plainTextToken;

        $response=[
            'status'=>true,
            'message'=>'Registered Successfully!',
            'data'=>[
                'user'=>$user,
                //'token'=>$token
            ]
        ];
        return response($response,201);
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|string|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response([
                'status'=>false,
                'message'=> $validator->errors()
            ],401);
        }

        $creds=$validator->validated();

        if(!Auth::attempt($creds)){
            return response([
                'status'=>false,
                'message'=>'invalid email or password'
            ],401);
        }

        //check email
      /*  $user=User::where('email',$request->email)->first();

        //check password
        if(!$user ||!Hash::check($request->password,$user->password)){

        }

        //create token
       // $token=$user->createToken('myappToken')->plainTextToken;
        */
        $response=[
            'status'=>true,
            'message'=>'Login successful!',
            'data'=>[
                'user'=>auth()->user(),
                //'token'=>$token
            ]
        ];

        return response($response,201);

    }
}
