<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function List(){
        return response()->json(User::all(),200);
    }

    public function Delete(User $user)
    {
        $user->delete();
        return $this->SuccessResponse(new UserResource($user),'Delete user Successful',200);
    }

    public function Accept(User $user)
    {
        if ($user) {
            $user->status = $user->status ? 0 : 1;
            $user->save();
            return $this->SuccessResponse(new UserResource($user),'Accept Author successful',200);
        }
    }
}






