<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnsureUserIsAdmin
 * 
 * This middleware ensures that the user making the request is an admin.
 */
class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is not an admin
        if ($request->user() && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
