<?php

/*namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated and has the correct role
        if (!auth()->check() || auth()->user()?->userRole?->role !== $role) {
            abort(403, 'Unauthorized: You do not have access to this section.');
        }

        return $next($request);
    }
}
*/




namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $userRole = auth()->user()?->userRole?->role ?? '';

        // Split multiple roles by | and check if user role matches any
        $allowedRoles = explode('|', $role);
        if (!auth()->check() || !in_array(strtolower($userRole), array_map('strtolower', $allowedRoles))) {
            abort(403, 'Unauthorized: You do not have access to this section.');
        }

        return $next($request);
    }
}