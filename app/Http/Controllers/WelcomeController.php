<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome(){

        $token = Str::random(60);
        cache(['welcome_token' => $token], now()->addMinutes(5));

        return response()->json(['message' => 'Welcome to Miladgram', 'token' => $token]);
    }
}
