<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class LanguagePrefixMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $language = Session::get('lang');

        if ($language) {
            $request->route()->setParameter('lang', $language);
            app('router')->prefix($language);
        }

        return $next($request);
    }
}
