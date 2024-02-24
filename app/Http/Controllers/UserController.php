<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    // use camelCase for your function name
    public function list(){
        //TODO add some filter and paginatin for this list
        $users= User::all();
        return response()->json($users,200);
        // return response()->json(User::all(),200);
    }
    
    public function show(User $user){

        return new UserResource($user);
    }

    public function delete(User $user)
    {
        $user->delete();
        // !!!!!!!! why do you send the user and send it as the response?!!!!
        return $this->SuccessResponse(new UserResource($user),'Delete user Successful',200);
    }

    public function accept(User $user)
    {
        if ($user) {
            // use not operation ( $user->status = !$user->status)
            $user->status = $user->status ? 0 : 1;
            $user->save();
            return $this->SuccessResponse(new UserResource($user),'Accept Author successful',200);
        }
    }
}






