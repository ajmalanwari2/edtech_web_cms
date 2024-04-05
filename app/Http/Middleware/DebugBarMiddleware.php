<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class DebugBarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // if (auth()->user() && in_array(auth()->user()->id, [2])) {
        //     \Debugbar::enable();
        // }
        // else {
        //     \Debugbar::disable();
        // }

        return $next($request);
    }
}
