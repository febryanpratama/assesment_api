<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthServices;
use App\Utils\ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    protected $authServices;
    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function login(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), 'Failed to login!');    
        }

        $response = $this->authServices->login($request);

        return $response;
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'roles' =>'required|in:Admin,User'
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), 'Failed to register');    
        }

        $response = $this->authServices->register($request);

        return $response;
    }
}
