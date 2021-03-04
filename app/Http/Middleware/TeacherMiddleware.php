<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
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
        }elseif (Auth::check() && Auth::user()->user_type == 'Student'){
            return redirect()->route('student.package');
        }
        return $next($request);
    }
}
