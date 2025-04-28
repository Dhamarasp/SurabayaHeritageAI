<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if user is logged in and has admin role (role_id = 1)
        if (Auth::user()->role_id == 1) {
            return $next($request);
        }
        
        // Redirect to home if not admin
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
