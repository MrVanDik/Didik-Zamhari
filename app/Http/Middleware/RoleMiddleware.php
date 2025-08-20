<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roles = [
            'Admin' => 1,
            'Pendaftaran' => 2,
            'Dokter' => 3,
            'Kasir' => 4,
        ];

        if (! $request->user() || $request->user()->id_role != $roles[$role]) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
