<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEmployee
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, ['employee', 'admin'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Brak dostępu do tego obszaru.');
    }
}
