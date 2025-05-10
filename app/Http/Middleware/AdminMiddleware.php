<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		$user = $request->user();

		// No user or user without the ADMIN role -> access denied
		if (!$user->hasRole('ADMIN') || !$user) {
			abort(403, 'Access denied. This route is reserved for admins only.');
		}
        return $next($request);
    }
}
