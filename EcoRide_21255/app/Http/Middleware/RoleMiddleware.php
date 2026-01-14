<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Sprawdzamy czy rola użytkownika pasuje do wymaganej
        if (Auth::user()->role !== $role) {
            abort(403, 'Brak dostępu! Ta strona jest tylko dla: ' . $role);
        }

        return $next($request);
    }
}