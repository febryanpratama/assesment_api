<?php

namespace App\Services;

use App\Models\User;
use App\Utils\ResponseCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class AuthServices{

    protected $responseCode;
    public function __construct(ResponseCode $responseCode)
    {
        $this->responseCode = $responseCode;
    }
    public function register($data){
        $validator = Validator::make($data->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' =>'required|in:Admin,User'
        ]);

        if($validator->fails()){
            return $this->responseCode->errorPost($validator->errors(), 'Failed to register');    
        }

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'roles' => $data->roles
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->responseCode->successPost([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'User Created');
    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        // dd($user);

        if (!$user || !Auth::attempt($data->only('email', 'password'))) {
            return $this->responseCode->errorPost('The provided credentials are incorrect.', 'Failed to login');
        }

        $token = $user->createToken('my-token')->plainTextToken;

        return $this->responseCode->successPost([
            'token' => $token,
            'Type' => 'Bearer',
            'role' => $user->roles // include user role in response
        ], "Success Login");
    }
}