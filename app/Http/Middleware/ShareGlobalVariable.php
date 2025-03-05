<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use App\Enums\Language;
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
                ->table('notification_system')
                ->where('users_id', Auth::user()->id)
                ->orderBy('created_at')
                ->limit(4)
                ->get();

            View::share('notificationSystem', $notificationSystem);

            if (Language::LIST_LANGUAGE[app()->getLocale()] == 'English') {
                $listTitle = Role::LIST_EN;
            } else {
                $listTitle = Role::LIST_VN;
            }

            View::share('listTitle', $listTitle);
        }

        return $next($request);
    }
}
