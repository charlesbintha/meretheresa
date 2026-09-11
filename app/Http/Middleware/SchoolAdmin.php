<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SchoolAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->is_school_admin, 403, 'Accès réservé à l’administration scolaire.');

        return $next($request);
    }
}
