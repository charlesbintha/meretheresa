<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user->is_active || (int) $request->session()->get('school_auth_version', 1) !== $user->auth_version) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $request->expectsJson()
                ? response()->json(['message' => 'Votre session a expiré ou votre compte a été désactivé.'], 401)
                : redirect()->route('login');
        }
        abort_unless($user->school_role_id || $user->isSchoolAdministrator(), 403, 'Aucun rôle attribué à ce compte.');

        return $next($request);
    }
}
