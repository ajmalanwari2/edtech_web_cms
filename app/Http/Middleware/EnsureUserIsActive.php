<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use DB;
use Session;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // \Log::info($request->user()->role);

        if ($request->user() && !$request->user()->status) {
            // throw new AuthenticationException;
            
            \Session::flush();
            $request->session()->put('info', 'Your account is not active');
            return redirect()->back();
        } else {
            //checking role
            if ($request->user()->role != 'admin') {
                \Session::flush();
                $request->session()->put('info', 'Only admins are allowed to login');
                return redirect()->back();
            }
            //updating last seen of user
            DB::statement("update users set last_seen  = current_timestamp() where id=" . $request->user()->id);
            return $next($request);
        }
    }
}
