<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Let guests through so they can reach the login page
        if (!auth()->check()) {
            return $next($request);
        }

        // Only block logged-in users who aren't admins
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        return $next($request);
    }
}
