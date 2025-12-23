<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated and has the correct role
        if (!auth()->check() || auth()->user()?->userRole()?->role !== $role) {
            abort(403, 'Unauthorized: You do not have access to this section.');
        }

        return $next($request);
    }
}