<?php

namespace App\Http\Middleware;

use Closure;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type == 'Admin'){
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
