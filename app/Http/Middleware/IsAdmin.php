<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login dan role adalah admin
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized action. Admin access only.');
        }

        return $next($request);
    }
}