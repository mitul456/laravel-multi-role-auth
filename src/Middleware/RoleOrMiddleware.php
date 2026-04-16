<?php

namespace Mitul456\LaravelMultiRoleAuth\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleOrMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized');
        }

        $hasAccess = false;
        foreach ($roles as $roleGroup) {
            $roleList = explode('|', $roleGroup);
            if ($request->user()->hasAllRoles($roleList)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Access denied - Required roles: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}