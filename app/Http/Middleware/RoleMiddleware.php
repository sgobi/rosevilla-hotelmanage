<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect('login');
        }

        // Admin always has access? The user didn't explicitly say so but usually yes.
        // However, let's stick to strict role checks first, or allow admin to access everything.
        // The user said "Admin can curd by staff, accountant", etc.
        // Let's just check if the user's role is in the allowed list.
        // If the user is admin, they might need access to staff routes too?
        // Let's assume explicit definition in routes for now.
        
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // If 'admin' is not in the allowed roles but the user IS an admin, 
        // usually we want to allow them (Super Admin concept), 
        // unless it's a specific 'accountant only' page.
        // For this simple app, I'll allow admin to access everything if I treat them as superuser,
        // OR I will just add 'admin' to the middleware call for all routes.
        // Let's go with the latter for clarity in routes.

        abort(403, 'Unauthorized. You do not have the required role.');
    }
}
