<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataManagementMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->get('data_management_verified', false)){
            abort(403);
        }

        return $next($request);
    }
}
