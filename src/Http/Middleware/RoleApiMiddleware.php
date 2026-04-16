<?php

namespace Mitul456\LaravelMultiRoleAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleApiMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$request->user()->hasRole($role)) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => "Role '{$role}' is required"
            ], 403);
        }

        return $next($request);
    }
}