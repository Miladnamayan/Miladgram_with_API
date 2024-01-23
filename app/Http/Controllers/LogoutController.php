<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends ApiController
{
    public function Logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message"=> "Logged out",
        ], 200);
    }
}
