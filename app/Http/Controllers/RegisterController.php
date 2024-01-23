<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
   public function Register(UserRequest $request){

    $imageName=Carbon::now()->microsecond .'.' . $request->image->extension();
    $request->image->storeAs('image/users',$imageName,'public');

        $user=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'role' => $request['role'],
            'image' => $imageName,
        ]);
        $token = $user->createToken('Register_Token');

        return response()->json([
            'user'=> new UserResource($user),
            'token'=> $token->plainTextToken
        ],201);


    }



}
