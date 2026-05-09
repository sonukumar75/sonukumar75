<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user?->tenant?->is_active, 403, 'Your laboratory subscription is not active.');

        view()->share('currentTenant', $user->tenant);

        return $next($request);
    }
}
