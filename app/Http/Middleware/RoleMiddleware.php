<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  use Illuminate\Support\Facades\Log;

public function handle(Request $request, Closure $next, string $role): Response
{
    Log::info('RoleMiddleware called', ['user' => $request->user(), 'required_role' => $role]);

    if (!$request->user() || $request->user()->role !== $role) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

}

