<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    // use camelCase for your function name
    public function List(){
        //TODO add some filter and paginatin for this list
        return response()->json(User::all(),200);
    }

    public function Delete(User $user)
    {
        $user->delete();
        // !!!!!!!! why do you send the user and send it as the response?!!!!
        return $this->SuccessResponse(new UserResource($user),'Delete user Successful',200);
    }

    public function Accept(User $user)
    {
        if ($user) {
            // use not operation ( $user->status = !$user->status)
            $user->status = $user->status ? 0 : 1;
            $user->save();
            return $this->SuccessResponse(new UserResource($user),'Accept Author successful',200);
        }
    }
}






