<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ShareGlobalVariable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->expectsJson()) {
            return $next($request);
        }

        if (Auth::check()) {
            $notificationSystem = DB::connection('mongodb')
                ->table('domains')
                ->where('users_id', Auth::user()->id)
                ->orderBy('created_at')
                ->limit(4)
                ->get();

            if (class_exists('Illuminate\Support\Facades\View')) {
                View::share('notificationSystem', $notificationSystem);
            } else {
                \Log::error('View facade not found');
            }
        }

        return $next($request);
    }
}
