<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( Auth::user() &&  Auth::user()->email == "modobom_pushsystem@gmail.com") {
            return redirect('/admin/push-system')->with('error','You have not admin access');
        }
        else if (Auth::user() &&  Auth::user()->type == "admin" || Auth::user() &&  Auth::user()->type == "user") {
            return $next($request);
        }
        return redirect('/admin')->with('error','You have not admin access');
    }
}
