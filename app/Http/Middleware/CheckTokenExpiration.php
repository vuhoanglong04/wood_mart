<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Auth::user()->currentAccessToken();
        
        if ($token && Carbon::parse($token->created_at)->addMinutes(1440)->isPast()) {
            $token->delete();
            return response()->json(['message' => 'Token has expired'], 401);
        }
        
        return $next($request);
    }
}
