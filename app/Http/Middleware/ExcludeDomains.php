<?php

namespace App\Http\Middleware;

use App\Enums\DomainAllow;
use Closure;
use Illuminate\Http\Request;

class ExcludeDomains
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
        $excludedDomains = DomainAllow::LIST_DOMAIN;

        if (in_array($request->getHost(), $excludedDomains)) {
            return $next($request);
        }

        return $next($request);
    }
}
