<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'guest') {
            abort(403);
        }

        return $next($request);
    }
}