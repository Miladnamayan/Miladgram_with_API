<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function Login(UserRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                "message"=> "User not found "
            ],401);
        }

        if(Hash::check($request->password, $user->password)){
            $token = $user->createToken('Login_Token');
            return response()->json([
                'user'=> new UserResource($user),
                'token'=> $token->plainTextToken
            ]);
        }
        return response()->json([
            "message"=> "The Password is incorrect "
        ], 401);
    }
}
