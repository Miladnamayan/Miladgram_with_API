<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $bearerToken = $request->bearerToken();
        // $user = Auth::guard('api')->user(); // Assuming you are using the 'api' guard

        // if (!$user || $user->api_token !== $bearerToken) {
        //     return response()->json([
        //         'message' => 'Unauthorized',
        //         'action' => 'redirect',
        //         'route' => 'step1'
        //     ], 401);
        // }
        return $next($request);
    }
}
